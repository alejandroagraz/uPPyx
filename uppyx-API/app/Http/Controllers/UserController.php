<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use App\Models\Role;
use App\Models\Social;
use App\Libraries\Push;
use App\Models\RoleUser;
use Webpatser\Uuid\Uuid;
use App\Libraries\General;
use App\Models\TokenDevice;
use Illuminate\Http\Request;
use App\Models\RequestLicense;
use Illuminate\Support\Facades\Mail;
use App\Validations\UserValidations;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Route;
use App\Mail\Confirm as ConfirmEmail;
use App\Mail\Activate as ActivateEmail;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\WelcomeSocial as SocialEmail;
use App\Validations\ForgotPasswordValidations;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::loginValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
            'deleted_at' => NULL
        ];
        if (Auth::once($credentials)) {
            $user = Auth::user();

            if ($user->hasRole('super-admin')) {
                return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 400);
            }
            if ($user->status == 2) {
                return General::responseErrorAPI(trans('messages.UserDisabled'), 'UserDisabled', 400);
            }

            if ($user->status == 3) {
                return General::responseErrorAPI(trans('messages.UserConfirm'), 'UserConfirm', 400);
            }

            if (is_null($user->stripe_customer_id) || empty($user->stripe_customer_id)) {
                $stripeController = new StripeController();
                $response = $stripeController->createCustomer($request, $user);
                if ($response->getStatusCode() != 200) {
                    $message = json_decode($response->getContent());
                    return General::responseErrorAPI($message->message, 'ErrorCreatingCustomer', 401);
                }
            }

            $tokenRequest = Request::create('/oauth/token', 'post');
            $token = Route::dispatch($tokenRequest)->getContent();
            $token = json_decode($token);
            $user->access_token = "Bearer " . $token->access_token;
            $user->roles = General::userRole($user);

            $data['user_id'] = $user->id;
            self::saveTokenDevice($data);

            return UserTransformer::transformItem($user);
        } else {
            return General::responseErrorAPI(trans('messages.ErrorLogin'), 'ErrorLogin', 401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function loginSocial(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::loginSocialValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        try {
            $userSocial = Socialite::driver($data['provider'])->stateless()->userFromToken($data['social_token']);
        } catch (\Exception $e) {
            return General::responseErrorAPI(trans('messages.ErrorLogin'), 'ErrorLogin', 401);
        }
        list($user, $message) = $this->findOrCreateUser($userSocial, $data, $request);
        if (!is_null($user)) {
            $data['user_id'] = $user->id;
            self::saveTokenDevice($data);
            $response = self::saveStripeCustomer($user, $request);
            if ($response !== true) {
                return $response;
            }
            $user = $this->generateToken($request, $user);
            return response()->json(UserTransformer::transformItem($user));
        } else {
            return General::responseErrorAPI(trans('messages.' . $message), $message, 400);
        }
    }

    /**
     * @param $userSocial
     * @param $data
     * @return User|mixed|null
     */
    private function findOrCreateUser($userSocial, $data)
    {
        list($message) = [""];
        $user = User::where($data['provider'] . "_id", $userSocial->id)->first();
//        $user = User::where("email", $data["email"])->first();
        $social = Social::where('social_id', '=', $userSocial->id)->where('provider', '=', $data['provider'])->first();
        if (count($user) <= 0) {
            if (count($social) <= 0) {
                // There is no combination of this social id and provider, so create new one
                $user = new User();
                $user->loadData($userSocial, $data);
                if ($user->save()) {
                    $this->attachRole($user);
                    Mail::to($user->email, $user->name)->send(new SocialEmail($user->name, $user->email, $data['lang']));
                } else {
                    list($user, $message) = [null, "ErrorSavingData"];
                }
            } else {
                //Load this existing social user
                $user = $social->user;
            }
        } else {
            if (!isset($data['avatar']) || is_null($data['avatar'])) {
                $data['avatar'] = (isset($userSocial->avatar) && !is_null($userSocial->avatar)) ? $userSocial->avatar
                    : null;
            }
            $user->update([$data['provider'] . "_id" => $userSocial->id,
                $data['provider'] . "_profile_picture" => $data['avatar']]);
        }

        Auth::login($user, true);
        if (Auth::user()) {
            if (count($social) <= 0) {
                $this->createSocial($user, $userSocial, $data);
            }
        } else {
            list($user, $message) = [null, "ErrorLogin"];
        }
        return [$user, $message];
    }

    /**
     * @param $user
     * @param $request
     * @return bool|mixed
     */
    public static function saveStripeCustomer($user, $request)
    {
        if (is_null($user->stripe_customer_id) || empty($user->stripe_customer_id)) {
            $stripeController = new StripeController();
            $response = $stripeController->createCustomer($request, $user);
            if ($response->getStatusCode() != 200) {
                $message = json_decode($response->getContent());
                return General::responseErrorAPI($message->message, 'ErrorCreatingCustomer', 400);
            }
        }
        return true;
    }

    /**
     * @param $user
     * @param $userSocial
     * @param $data
     */
    public function createSocial($user, $userSocial, $data)
    {
        $socialData = new Social();
        $socialData->loadSocialData($user, $userSocial, $data);
        $user->socialLogins()->save($socialData);
        return;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::logoutValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        } else {
            $user = User::whereUuid($data['user_id'])->first();
            $token_device = new TokenDevice();
            $token_device->deleteTokeDevice($user->id, $data['token_device']);
            return General::responseSuccessAPI(trans('messages.SuccessLogout'), 'SuccessLogout', 200);
        }
    }

    /**
     * @param $data
     */
    public static function saveTokenDevice($data)
    {
        $tokens = TokenDevice::whereTokenDevice($data['token_device'])->orWhere('user_id', '=', $data['user_id'])->get();
        if (count($tokens) > 0) {
            foreach ($tokens as $token) {
                $token->forceDelete();
            }
        }
        $tokenDevice = new TokenDevice();
        $tokenDevice->fill($data);
        $tokenDevice->uuid = '';
        $tokenDevice->save();
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function signUp(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::signUpValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        $user = new User();
        list($user->uuid, $user->status, $user->default_lang) = ['', 3, $data['lang']];
        $user->fill($data);
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            $this->attachRole($user);
            $user = $this->generateToken($request, $user);
            Mail::to($data['email'], $data['name'])->send(new ConfirmEmail($data['name'], $data['email'], $data['lang']));
            return UserTransformer::transformItem($user);
        } else {
            return General::responseErrorAPI(trans('messages.ErrorSavingData'), 'ErrorSavingData', 400);
        }
    }

    /**
     * @param $user
     * @return RoleUser
     */
    public function attachRole($user)
    {
        $role = Role::whereName('user')->firstOrFail();
        //attach role
        $roleUser = new RoleUser();
        $roleUser->user_id = $user->id;
        $roleUser->role_id = $role->id;
        $roleUser->save();
        return $roleUser;
    }

    /**
     * @param $request
     * @param $user
     * @return mixed
     */
    public function generateToken($request, $user)
    {
        $request["grant_type"] = ($request->grant_type != 'password') ? 'password' : $request->grant_type;
        $request["client_id"] = $request->client_id;
        $request["client_secret"] = $request->client_secret;
        $request["username"] = $request["email"];
        if (!isset($request["password"])) {
            $token = $user->createToken('Access Token');
            $accessToken = $token->accessToken;
        } else {
            $tokenRequest = Request::create('/oauth/token', 'post');
            $token = Route::dispatch($tokenRequest)->getContent();
            $token = json_decode($token);
            $accessToken = $token->access_token;
        }

        $user = User::whereId($user->id)->first();
        $user->access_token = "Bearer " . $accessToken;
        $user->roles = General::userRole($user);
        return $user;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function resendEmailConfirmation(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::resendEmailConfirmationValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            if ($user->status == 3) {
                Mail::to($request->email, $user->name)->send(new ConfirmEmail($user->name, $user->email, $request->lang));

                return General::responseErrorAPI(trans('messages.VerifyEmailSent'), 'VerifyEmailSent', 200);
            } else {
                return General::responseErrorAPI(trans('messages.AccountAlreadyVerified'), 'AccountAlreadyVerified');
            }
        } else {
            return General::responseErrorAPI(trans('messages.UserNotFound'), 'UserNotFound', 404);
        }

    }

    /**
     * @param $email
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAccount($email, $lang)
    {
        $user = User::whereEmail(base64_decode($email))->first();
        if ($user) {
            if ($user->status == 3) {
                $user->update(['status' => 1]);
                Mail::to(base64_decode($email), $user->name)->send(new ActivateEmail($user->name, $lang));
                if ($lang == 'en') {
                    return redirect('activate-account')->with('success', 'Account activated successfully. You can login now and enjoy our services.');
                } else {
                    return redirect('activate-account')->with('success', '¡Tú cuenta ha sido activada con éxito!. Ya puedes ingresar y disfrutar de tu próxima renta');
                }
            } elseif ($user->status == 2) {
                if ($lang == 'en') {
                    return redirect('activate-account')->with('error', 'Your account is disabled.');
                } else {
                    return redirect('activate-account')->with('error', 'Su cuenta se encuentra deshabilitada.');
                }
            } elseif ($user->status == 1) {
                if ($lang == 'en') {
                    return redirect('activate-account')->with('error', 'Your account is already enabled.');
                } else {
                    return redirect('activate-account')->with('error', 'Su cuenta ya se encuentra activada.');
                }
            }
        } else {
            if ($lang == 'en') {
                return redirect('activate-account')->with('error', 'This account is invalid.');
            } else {
                return redirect('activate-account')->with('error', 'Es posible que su cuenta sea inválida.');
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function activateAccountView()
    {
        if (session('error') || session('success')) {
            return view('auth.activate-account');
        } else {
            return redirect('/');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadProfilePicture(Request $request)
    {
        if ($request->delete == 'true') {
            $user = User::whereUuid($request->user_id)->first();
            if (count($user) > 0) {
                if ($request->picture_profile == 'true') {
                    list($field, $destinationPath, $image) = ['profile_picture', 'userProfile', $user->profile_picture];
                } else {
                    list($field, $destinationPath, $image) = ['license_picture', 'licenseProfile', $user->license_picture];
                }
                if ($image != '') {
                    $this->deleteImageS3($destinationPath, $image);
                }
                $user->update([$field => null]);
                return General::responseSuccessAPI(trans('messages.ImageDeletedSuccess'));
            } else {
                return General::responseErrorAPI(trans('messages.UserNotFound'));
            }
        }
        $file = ['image' => $request->file('image'), 'user_id' => $request->input('user_id'),
            'lang' => $request->input('lang'), "picture_profile" => $request->input('picture_profile')];
        if (!$request->hasFile('image')) {
            return General::responseErrorAPI(trans('messages.ImageRequired'), 'DataNotFound', 404);
        }
        $validator = UserValidations::uploadProfilePictureValidation($file);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first());
        } else {
            list($imageObject, $randString) = [$request->file('image'), time() . '-' . Uuid::generate(4)->string];
            //path where image will be stored
            $destinationPath = ($request->picture_profile == "true") ? 'userProfile' : 'licenseProfile';
            //encrypt image name
            $imageName = sha1($imageObject->getClientOriginalName() . $randString) . '.' . $imageObject->getClientOriginalExtension();
            //create folder if not exists.
            if (!in_array($destinationPath, $this->getDirectoriesS3())) {
                $this->createDirectoryS3($destinationPath);
            }
            //storage image in s3.
            $upload = $this->uploadFileToS3($destinationPath, $imageName, $imageObject);
            if ($upload) {
                //find user - find image
                $user = User::whereUuid($request->user_id)->first();
                if ($request->picture_profile == "true") {
                    $this->deleteImageS3($destinationPath, $user->profile_picture);
                    $user->update(['profile_picture' => $imageName]);
                } else {
                    $this->deleteImageS3($destinationPath, $user->license_picture);
                    $user->update(['license_picture' => $imageName]);
                }
                $data['image_name'] = $imageName;
                return General::responseSuccessAPI(trans('messages.fileUploadedSuccessfully'), $data, 201);
            } else {
                return General::responseErrorAPI(trans('messages.FileNotUploaded'), 'FileNotUploaded');
            }
        }
    }

    /**
     * @param Request $request
     * @param $userId
     * @return array|mixed
     */
    public function getUser(Request $request, $userId)
    {
        $request->merge(['user_id' => $userId]);
        $data = $request->all();
        $validator = UserValidations::getUserValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $user = User::whereUuid($userId)->first();
        if ($user) {
            $user->roles = General::userRole($user);
            return UserTransformer::transformItem($user);
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getUserByField(Request $request)
    {
        $data = $request->all();
        $validator = UserValidations::getUserByFieldValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $user = User::where($data['column'], $data['value'])->first();
        if (count($user) > 0) {
            return response()->json(UserTransformer::transformItem($user));
        } else {
            return response()->json(['data' => false, 'message' => trans('messages.DataNotFound')]);
        }
    }

    /**
     * @param Request $request
     * @param $userId
     * @return mixed
     */
    public function updateUser(Request $request, $userId)
    {
        $request->merge(['user_id' => $userId]);
        $data = $request->all();
        $validator = UserValidations::updateUserValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        } else {
            $user = User::whereUuid($userId)->first();
            $data = $request->only(['name', 'phone', 'birth_of_date', 'country']);
            if ($user) {
                $user->fill($data);
                if ($user->save()) {
                    return General::responseSuccessAPI(trans('messages.SuccessUpdate'), 'SuccessUpdate', 200);
                } else {
                    return General::responseErrorAPI(trans('messages.ErrorSavingData'), 'ErrorSavingData', 400);
                }
            } else {
                return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 400);
            }
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function sendPushTest(Request $request)
    {
        $view = ($request->view) ? $request->view : 1;
        $sendPush = Push::sendPushNotification($request->token_device, $request->message, $request->os, ['view' => $view]);
        if ($sendPush) {
            return General::responseSuccessAPI('Push sent');
        } else {
            return General::responseErrorAPI('Couldn\'t send push');
        }
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadUserLicense(Request $request)
    {
        $file = ['image' => $request->file('image'), 'user_id' => $request->input('user_id'),
            'lang' => $request->input('lang'), "picture_profile" => $request->input('picture_profile')];
        if (!$request->hasFile('image')) {
            return General::responseErrorAPI(trans('messages.ImageRequired'), 'DataNotFound', 404);
        }
        $validator = UserValidations::uploadUserLicenseValidation($file);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first());
        } else {
            list($imageObject, $randString) = [$request->file('image'), time() . '-' . Uuid::generate(4)->string];
            //path where image will be stored
            $destinationPath = 'licenseProfile';
            //encrypt image name
            $imageName = sha1($imageObject->getClientOriginalName() . $randString) . '.' . $imageObject->getClientOriginalExtension();
            //create folder if not exists.
            if (!in_array($destinationPath, $this->getDirectoriesS3())) {
                $this->createDirectoryS3($destinationPath);
            }
            $upload = $this->uploadFileToS3($destinationPath, $imageName, $imageObject);
            if ($upload) {
                //find user
                list($imageId, $user) = ["", User::whereUuid($request->user_id)->first()];
                if ($request->picture_profile == "true") {
                    if ($user->profile_picture != '') {
                        $this->deleteImageS3($destinationPath, $user->license_picture);
                    }
                    $user->update(['license_picture' => $imageName]);
                } else {
                    $license = RequestLicense::whereUserId($user->id)->first();
                    if (count($license) > 0) {
                        $license->delete();
                    }
                    $license = new RequestLicense();
                    $license->license_name = $imageName;
                    $license->user_id = $user->id;
                    $license->save();
                    $imageId = $license->id;
                    if ($user->license_picture != '') {
                        $this->deleteImageS3($destinationPath, $user->license_picture);
                    }
                    $user->update(['license_picture' => $imageName]);
                }
                $data['image_name'] = $imageName;
                $data['image_id'] = $imageId;
                return General::responseSuccessAPI(trans('messages.fileUploadedSuccessfully'), $data, 201);
            } else {
                return General::responseErrorAPI(trans('messages.FileNotUploaded'), 'FileNotUploaded');
            }
        }
    }

    /**
     * @param Request $request
     * @param $userId
     * @return mixed
     */
    public function changePasswordUser(Request $request, $userId)
    {
        $request->merge(['user_id' => $userId]);
        $data = $request->all();
        $validator = UserValidations::changePasswordUserValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return General::responseSuccessAPI(trans('messages.PasswordChanged'), 'PasswordChangedSuccessfully');
        } else {
            return General::responseErrorAPI(trans('messages.ErrorChangingPassword'), 'ErrorChangingPassword');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userProfile()
    {
        return view('admin-profile', array('user' => Auth::user()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function updateProfile(Request $request)
    {
        list($uploadImage, $email, $destinationPath) = [false, $request->email, 'userProfile'];
        $user = ($email != "") ? $user = User::whereEmail($request->email)->first() : $user = Auth::user();
        if ($request->hasFile('picture')) {
            $imageObject = $request->file('picture');
            $validator = UserValidations::imageProfileValidation($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator, 'image')->withInput();
            } else {
                $randString = time() . '-' . Uuid::generate(4)->string;
                $imageName = sha1($imageObject->getClientOriginalName() . $randString) . '.' . $imageObject->getClientOriginalExtension();
                $imageResize = Image::make($imageObject)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->stream()->detach();
                //create folder if not exists.
                if (!in_array($destinationPath, $this->getDirectoriesS3())) {
                    $this->createDirectoryS3($destinationPath);
                }
                $upload = $this->uploadResizeFileToS3($destinationPath, $imageName, $imageResize);
                if ($upload) {
                    if ($user->profile_picture != '') {
                        $this->deleteImageS3($destinationPath, $user->profile_picture);
                    }
                    $user->update(['profile_picture' => $imageName]);
                    $uploadImage = true;
                } else {
                    $uploadImage = false;
                }
            }
        }
        if ($request->password) {
            $validator = ForgotPasswordValidations::resetProfileValidation($request);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator, 'profile')
                    ->withInput();
            } else {
                $user->password = bcrypt($request->password);
                if ($user->save()) {
                    return redirect('/user-profile')->with('user', Auth::user())->with('message_type', 'success')
                        ->with('status', 'Datos actualizados correctamente!');
                } else {
                    return redirect('/user-profile')->with('user', Auth::user())->with('message_type', 'danger')
                        ->with('status', 'No se ha podido actualizar los datos');

                }
            }
        }
        return ($uploadImage === true) ? redirect('/user-profile')->with('user', Auth::user())->with('message_type', 'success')
            ->with('status', 'Imagen de perfil actualizada correctamente!') : view('admin-profile', array('user' => Auth::user()));
    }

    /**
     * @param $id
     * @param $picture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function deleteUserProfile($id, $picture)
    {
        $destinationPath = 'userProfile';
        $delete = $this->deleteImageS3($destinationPath, $picture);
        if ($delete) {
            $user = User::whereId($id)->first();
            $user->update(['profile_picture' => null]);
            return redirect('/user-profile')->with('user', Auth::user())->with('message_type', 'success')
                ->with('status', 'Imagen de perfil eliminada correctamente!');
        } else {
            return redirect('/user-profile')->with('user', Auth::user())->with('message_type', 'danger')
                ->with('status', 'No se ha podido eliminar la imagen');
        }
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @param null $fileObject
     * @return mixed
     */
    public function uploadFileToS3($destinationPath, $imageName, $fileObject = null)
    {
        if ($fileObject == null) {
            $fileObject = $imageName;
        }
        $s3 = Storage::disk('s3');
        $filePath = $destinationPath . "/" . $imageName;
        $upload = $s3->put($filePath, file_get_contents($fileObject), 'public');
        return $upload;
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @param null $fileString
     * @return mixed
     */
    public function uploadResizeFileToS3($destinationPath, $imageName, $fileString = null)
    {
        if ($fileString == null) {
            $fileString = $imageName;
        }
        $s3 = Storage::disk('s3');
        $filePath = $destinationPath . "/" . $imageName;
        $upload = $s3->put($filePath, $fileString, 'public');
        return $upload;
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @return null
     */
    public function getUrlImageS3($destinationPath, $imageName)
    {
        $exists = $this->verifyImageS3($destinationPath, $imageName);
        if ($exists) {
            $url = Storage::disk('s3')->url($destinationPath . "/" . $imageName);
        } else {
            $url = null;
        }
        return $url;
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @return bool
     */
    public function verifyImageS3($destinationPath, $imageName)
    {
        $exists = Storage::disk('s3')->exists($destinationPath . "/" . $imageName);
        return ($exists == true) ? true : false;
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @return mixed
     */
    public function deleteImageS3($destinationPath, $imageName)
    {
        $delete = Storage::disk('s3')->delete($destinationPath . "/" . $imageName);
        return $delete;
    }

    /**
     * @param $destinationPath
     * @param $imageName
     * @return mixed
     */
    public function getImageS3($destinationPath, $imageName)
    {
        $content = Storage::disk('s3')->get($destinationPath . "/" . $imageName);
        return $content;
    }

    /**
     * @param null $directory
     * @return mixed
     */
    public function getDirectoriesS3($directory = null)
    {
        $directories = ($directory != null) ? Storage::disk('s3')->directories($directory)
            : Storage::disk('s3')->directories();
        return $directories;
    }

    /**
     * @param $directory
     * @return mixed
     */
    public function getAllDirectoriesS3($directory = null)
    {
        $directories = ($directory != null) ? Storage::disk('s3')->allDirectories($directory)
            : Storage::disk('s3')->allDirectories();
        return $directories;
    }

    /**
     * @param $directory
     * @return mixed
     */
    public function createDirectoryS3($directory)
    {
        $newDirectory = Storage::disk('s3')->makeDirectory($directory);
        return $newDirectory;
    }

    /**
     * @param $directory
     * @return mixed
     */
    public function deleteDirectoryS3($directory)
    {
        $deletedDirectory = Storage::disk('s3')->deleteDirectory($directory);
        return $deletedDirectory;
    }

    /**
     * @param null $directory
     * @return mixed
     */
    public function getFilesS3($directory = null)
    {
        $files = ($directory != null) ? Storage::disk('s3')->files($directory)
            : Storage::disk('s3')->files();
        return $files;
    }

    /**
     * @param $directory
     * @return mixed
     */
    public function getAllFilesS3($directory = null)
    {
        $files = ($directory != null) ? Storage::disk('s3')->allFiles($directory)
            : Storage::disk('s3')->allFiles();
        return $files;
    }

    /**
     * @param $oldPath
     * @param $newPath
     * @return mixed
     */
    public function copyFileS3($oldPath, $newPath)
    {
        $copy = Storage::disk('s3')->copy($oldPath, $newPath);
        return $copy;
    }

    /**
     * @param $oldPath
     * @param $newPath
     * @return mixed
     */
    public function moveFileS3($oldPath, $newPath)
    {
        $move = Storage::disk('s3')->move($oldPath, $newPath);
        return $move;
    }

}