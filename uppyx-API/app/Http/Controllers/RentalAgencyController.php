<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Uuids;
use App\User;
use Validator;
use Datatables;
use Carbon\Carbon;
use App\Quotation;
use App\Libraries\General;
use App\Models\RentalAgency;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome as WelcomeEmail;
use App\Models\RentalRequestExtension;
use App\Validations\RentalAgencyValidations;
use App\Mail\WelcomeAgent as WelcomeEmailAgent;


/**
 * Class RentalAgencyController
 * @package App\Http\Controllers
 */
class RentalAgencyController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewRegister(Request $request)
    {
        return view('register-rent-car');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = RentalAgencyValidations::registerValidation($input);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'rental')
                ->withInput();
        } else {
            $request->merge(['user_id' => Auth::user()->id, 'uuid' => 1]);
            $input = $request->all();
            $agency = new RentalAgency;
            $agency->fill($input);
            $agency->save();
            return redirect('/register-rent-car')->with('message_type', 'success')->with('status', 'Car Rental Guardado Exitosamente!');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listAdminRental(Request $request)
    {
        $input = $request->get('search');
        $admin_rental = RentalAgency::whereNotNull('id');
        if ($input != '') {
            $admin_rental->where('name', 'like', "%$input%");
        }
        $result = $admin_rental->get();
        return view('list_admin_rental', ['admin_rental' => $result, 'request' => $request]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listUserAdminRental(Request $request)
    {
        $users = User::with('rentalAgencies')->whereHas('roles', function ($q) {
            $q->whereIn('name', ['super-admin', 'rent-admin']);
        });
        if (isset($request->agency) && $request->agency != '') {
            $users->whereRentalAgencyId($request->agency);
        }
        $obj = $users->get();
        return view('agencies.list-user-rental', ['users' => $obj]); // 'agencies' => $agencies,'request'=>$request]);
    }

    /**
     * Vista para Editar un Administrador de una Agencia
     * @param $id
     * @return $this
     */
    public function viewUserAdminRental($id)
    {
        $user = User::find($id);
        $agencies = RentalAgency::active()->get();
        return view('agencies.update-user-rental')->with('user', $user)->with('agencies', $agencies);
    }

    /**
     * Función que actualiza los datos de un Administrador de una Agencia
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatedUserAdminRental(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $validator = RentalAgencyValidations::updatedUserAdminRentalValidation($input, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rental')->withInput();

        } else {
            if ($input['roleOption'] == 1) {
                $request->merge(['user_id' => Auth::user()->id, 'rental_agency_id' => null]);
            } else {
                $request->merge(['user_id' => Auth::user()->id, 'rental_agency_id' => $input['agency_id']]);
            }
            $input = $request->all();
            $user = User::find($id);
            $user->fill($input);
            $user->save();
            return redirect('/list-user-rental')->with('message_type', 'success')->with('status', 'Usuario Actualizado Exitosamente!');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableUserAdminRental(Request $request, $id)
    {
        $users = User::find($id);
        $users->status = 2;
        $users->save();
        return redirect('/list-user-rental')->with('message_type', 'success')->with('status', 'Usuario Inhabilitado!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableUserAdminRental(Request $request, $id)
    {
        $users = User::find($id);
        $users->status = 1;
        $users->save();
        return redirect('/list-user-rental')->with('message_type', 'success')->with('status', 'Usuario Habilitado!');
    }

    /**
     * @param $id
     * @return $this
     */
    public function viewAdminRental($id)
    {
        $agency = RentalAgency::find($id);
        return view('update_admin_rental')->with('agency', $agency);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatedAdminRental(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $validator = RentalAgencyValidations::updatedAdminRentalValidation($input);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rental')->withInput();

        } else {
            $request->merge(['user_id' => Auth::user()->id, 'uuid' => 1]);
            $input = $request->all();
            $agency = RentalAgency::find($id);
            $agency->fill($input);
            $agency->save();
            return redirect('/list-admin-rental')->with('message_type', 'success')->with('status', 'Car Rental Actualizado!');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableAdminRental(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $input = $request->all();
        $validator = RentalAgencyValidations::disableAdminRentalValidation($input);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rental')->withInput();
        }
        $agency = RentalAgency::find($id);
        $agency->status = 2;
        if ($agency->save()) {
            User::whereRentalAgencyId($agency->id)->update(['status' => 2, 'updated_at' => date('Y-m-d H:i:s')]);
        }
        return redirect('/list-admin-rental')->with('message_type', 'success')->with('status', 'Admin Inhabilitado!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableAdminRental(Request $request, $id)
    {
        $agency = RentalAgency::find($id);
        $agency->status = 1;
        if ($agency->save()) {
            User::whereRentalAgencyId($agency->id)->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
        }
        return redirect('/list-admin-rental')->with('message_type', 'success')->with('status', 'Admin Habilitado!');
    }

    /**
     * @return $this
     */
    public function viewRegisterAdminAgency()
    {
        $agency = RentalAgency::active()->get();
        return view('agencies.register-admin')->with('agency', $agency);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function registerAdminAgency(Request $request)
    {
        $input = $request->all();
        $password = General::randomPassword();
        $randomChanged = bcrypt($password);
        $validator = RentalAgencyValidations::registerAdminRentalValidation($input);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rental')->withInput();
        } else {
            if ($input['roleOption'] == 1) {
                $request->merge(['rental_agency_id' => null, 'password' => $randomChanged, 'uuid' => 1]);
            } else {
                $request->merge(['rental_agency_id' => $input['agency_id'], 'password' => $randomChanged, 'uuid' => 1]);
            }
            $input = $request->all();
            $user = new User;
            $user->fill($input);
            $user->save();
            $user->roles()->attach($input['roleOption']);
            Mail::to($input['email'], $input['name'])->send(new WelcomeEmail($input['name'], $password, $input['email']));
            return redirect('/register-rental-admin')->with('message_type', 'success')->with('status', 'Usuario Guardado Exitosamente!');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewRegisterAgent()
    {
        return view('adminagent.register-agent');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function registerAgent(Request $request)
    {
        $input = $request->all();
        $password = General::randomPassword();
        $randomChanged = bcrypt($password);
        $validator = RentalAgencyValidations::registerAgent($input);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'rental')
                ->withInput();
        } else {
            $request->merge(['rental_agency_id' => Auth::user()->rental_agency_id, 'password' => $randomChanged, 'uuid' => 1]);
            $user = new User;
            $user->fill($request->toArray());
            $user->save();
            $user->roles()->attach(4);
            Mail::to($input['email'], $input['name'])
                ->send(new WelcomeEmailAgent($input['name'], $password, $input['email']));

            return redirect('/register-agent')->with('message_type', 'success')->with('status', 'Usuario Agente Guardado Exitosamente!');
        }
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function listAgent(Request $request)
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('rental_agency_id', Auth::user()->rental_agency_id)->where('name', 'agent');
        })->SoftDelete()->get();
        return view('adminagent.list-agent')->with('users', $users);
    }

    /**
     * Vista para Editar un Agente de una Agencia
     * @param $id
     * @return $this
     */
    public function viewUpdateAgent($id)
    {
        $user = User::find($id);
        return view('adminagent.update-agent')->with('user', $user);
    }

    /**
     * Función que actualiza los datos de un Agente de una Agencia
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatedAgent(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $validator = RentalAgencyValidations::updatedAgent($input, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rental')->withInput();

        } else {
            $request->merge(['rental_agency_id' => Auth::user()->rental_agency_id]);
            $input = $request->all();
            $user = User::find($id);
            $user->fill($input);
            $user->save();
            return redirect('/list-agent')->with('message_type', 'success')->with('status', 'Agente Actualizado!');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableAgent(Request $request, $id)
    {
        $agent = User::find($id);
        $agent->status = 2;
        $agent->save();
        return redirect('/list-agent')->with('message_type', 'success')->with('status', 'Agente Inhabilitado!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableAgent(Request $request, $id)
    {
        $agent = User::find($id);
        $agent->status = 1;
        $agent->save();
        return redirect('/list-agent')->with('message_type', 'success')->with('status', 'Agente Habilitado!');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewRequestRental()
    {
        $statuses = ['sent', 'taken-manager', 'taken-user', 'on-way', 'checking', 'on-board', 'taken-user-dropoff',
            'returned-car', 'finished', 'cancelled', 'cancelled-system', 'cancelled-app'];
        $agencyId = Auth::user()->rental_agency_id;
        $maxTotalCostRequests = (int)RentalRequest::where('taken_by_agency', $agencyId)->max('total_cost');
        $maxTotalCostExtensions = (int)RentalRequestExtension::whereHas('rentalRequest', function ($query) use ($agencyId) {
            $query->where('taken_by_agency', $agencyId);
        })->max('total_cost');
        $maxTotalCost = ($maxTotalCostRequests >= $maxTotalCostExtensions) ? $maxTotalCostRequests : $maxTotalCostExtensions;
        return view('adminagent.list-request', ['statuses' => $statuses, 'maxTotalCost' => $maxTotalCost]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function viewRequestRentalData(Request $request)
    {
        $rentalRequests = RentalRequest::with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser',
            'takenByUserDropOff', 'payments', 'classification', 'requestCity', 'cancellationRequestReasons', 'discountCodes',
            'rentalRequestExtensions', 'rentalRequestRates'])->where('taken_by_agency', Auth::user()->rental_agency_id)->get();

        if ($request->statuses > 0) {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                return (in_array($rentalRequest->status, $request->statuses)) ? true : false;
            });
        }
        if ($request->from != "" && $request->to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                list($from, $to) = [Carbon::parse($request->from), Carbon::parse($request->to)->addHours(23)
                    ->addMinutes(59)->addSeconds(59)];
                return (Carbon::parse($rentalRequest->full_created_at)->between($from, $to)) ? true : false;
            });
        }
        if ($request->pickup_date_from != "" && $request->pickup_date_to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                list($from, $to) = [Carbon::parse($request->pickup_date_from), Carbon::parse($request->pickup_date_to)];
                return (Carbon::parse($rentalRequest->full_pickup_date)->between($from, $to)) ? true : false;
            });
        }
        if ($request->min != "" && $request->max != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = RentalRequestController::getRequestObject($rentalRequest);
                return ($object->total_days >= $request->min && $object->total_days <= $request->max) ? true : false;
            });
        }
        if ($request->min_cost != "" && $request->min_cost != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = RentalRequestController::getRequestObject($rentalRequest);
                return ($object->total_cost >= $request->min_cost && $object->total_cost <= $request->max_cost) ? true : false;
            });
        }
        if ($request->dropoff_date_from != "" && $request->dropoff_date_to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = RentalRequestController::getRequestObject($rentalRequest);
                list($from, $to) = [Carbon::parse($request->dropoff_date_from), Carbon::parse($request->dropoff_date_to)];
                return (Carbon::parse($object->full_dropoff_date)->between($from, $to)) ? true : false;
            });
        }

        return Datatables::of($rentalRequests)->make(true);
    }
}
