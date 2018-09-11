<?php

namespace App\Libraries;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class General
 * @package App\Libraries
 */
class General
{
    /**
     * @param $message
     * @param bool|false $data
     * @param int $code
     * @return mixed
     */
    static function responseSuccessAPI($message, $data=false, $code=200){
        $response = [
            "message" => $message,
            "code" => $code,
            "data" => $data
        ];
        $obj = new General();
        return $obj->responseData($response);
    }


    /**
     * @param $message
     * @param bool|false $title
     * @param int $code
     * @return mixed
     */
    static function responseErrorAPI($message, $title=false, $code=400){
        $response = [
            "code" => $code,
            "message" => $message,
            "title" => ($title)?$title:"",
        ];
        $obj = new General();
        return $obj->responseData($response);
    }

    /**
     * @param $arr
     * @return mixed
     */
    public function responseData($arr){
        $code = $arr['code'];
        unset($arr['code']);
        if(isset($arr['title'])){
            if($arr['title']==''){
                unset($arr['title']);
            }
        }
        if(isset($arr['data'])){
            if($arr['data']==''){
                unset($arr['data']);
            }
        }

        return response()->json($arr, $code);
    }

    /**
     * @param $token
     * @return string
     */
    public static function buildUrlFacebookToken($token){
        $url = 'https://graph.facebook.com/oauth/access_token_info?client_id=APPID&access_token='.$token;
        return $url;
    }

    /**
     * @param $email
     */
    public static function generateUniqueUsername($email){
        $username = explode("@", $email);
        $lengthUsername = 20;

        $Username = $username[0];
        if(strlen($Username)>$lengthUsername){
            $Username = substr($Username, 0, $lengthUsername);
        }
        $data = User::where('username', $Username)->first();
        if($data){
            $countUsers = User::where('username','like', $Username)->get();

            $a=count($countUsers);
            if(strlen($Username.$a)>$lengthUsername){
                $Username = substr($Username, 0, $lengthUsername-strlen($a));
            }
            while(count(User::where('username', $Username.$a)->first())>0){
                $a++;
                if(strlen($Username.$a)>$lengthUsername){
                    $Username = substr($Username, 0, $lengthUsername-strlen($a));
                }
            }
            return $Username.$a;
        }else{
            return $Username;
        }

    }

    /**
     * @param $data
     * @return string
     */
    public static function language($data){
        if(isset($data['lang'])){
            $language = $data['lang'];
        }else{
            $language = 'en';
        }
        return strtolower($language);
    }

    /**
     * @return string
     */
    public static function genericPassword(){
        $password = 'PlayMakerDefaultPassword2016';
        return $password;
    }

    public static function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * Format YYYY-MM-DD
     * @param $date
     * @param string $lang
     * @return bool
     */
    public static function isAdult($date1, $lang = 'en')
    {
        $date = explode("-", $date1);
        if($lang=='en'){
            $age = Carbon::createFromDate($date[0], $date[1], $date[2])->age;
            if ($age < 18) {
                return false;
            }
        }else if($lang=='es'){
            $age = Carbon::createFromDate($date[2], $date[1], $date[0])->age;
            if ($age < 18) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $date
     * @param string $lang
     */
    public static function saveDate($date, $lang = 'en')
    {
        $date2 = explode("-", $date);
        if($lang=='es'){
            $newDate = $date2[2]."-".$date2[1]."-".$date2[0];
        }else{
            $newDate = $date;
        }
        return $newDate;
    }

    /**
     * @param $date
     * @param string $lang
     */
    public static function showDate($date, $lang = 'en')
    {
        $date2 = explode("-", $date);
        if($lang=='es'){
            $newDate = $date2[2]."-".$date2[1]."-".$date2[0];
        }else{
            $newDate = $date;
        }
        return $newDate;
    }

    /**
     * @param $endDate
     * @param bool|false $startDate
     * @return float
     */
    public static function elapsedDays($endDate, $startDate=false){
        $startDate = (!$startDate)?date('Y-m-d'):$startDate;
        $diff = abs(strtotime($endDate) - strtotime($startDate));
        $days = floor(($diff / (60*60*24)));
        return $days;

    }

    /**
     * @param $email
     * @return bool
     */
    public static function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param $user
     * @return array
     */
    public static function userRole($user){
        $roles = $user->roles;
        $roleList = [];
        foreach($roles as $rol){
            $roleList[] = $rol->name;
        }
        return $roleList;
    }

}