<?php

namespace App\Http\Controllers;

use App\User;
use App\Libraries\Push;
use App\Models\PushLog;
use App\Transformers\RentalRequestTransformer;

class PushLogsController extends Controller
{

    /**
     * @param $rentalRequest
     * @param $enablePushLog
     * @param $enableResendPush
     * @return bool
     */
    public static function sendPushToManagers($rentalRequest, $enablePushLog, $enableResendPush)
    {
        // Get all managers
        $managers = User::whereHas('roles', function ($query) {
            $query->whereName('rent-admin');
        })->whereHas('devices')->SoftDelete()->whereStatus(1)->get();

        if (count($managers) > 0) {
            list($countPush, $requestTransformed) = [0, RentalRequestTransformer::transformItem($rentalRequest)];
            foreach ($managers as $manager) {
                foreach ($manager->devices as $device) {
                    if (!is_null($manager->default_lang)) {
                        $locale = ($manager->default_lang === 'en') ? 'en' : 'es';
                    } else {
                        $locale = null;
                    }
                    list ($tokenDevice, $operativeSystem, $message, $arrayData) = [$device->token_device,
                        $device->operative_system, trans('messages.ThereIsNewRequest', [], 'messages', $locale),
                        ['view' => '3', 'body' => (isset($requestTransformed['data'])) ? array_first($requestTransformed['data']) : null]];
                    $push = Push::sendPushNotification($tokenDevice, $message, $operativeSystem, $arrayData);
                    $pushLog = self::createPushLog($push, $device, $message, $rentalRequest, $enablePushLog);
                    if ($push) {
                        $countPush++;
                    } else {
                        self::resendPushNotification($device, $message, $arrayData, $pushLog, $enableResendPush);
                    }
                }
            }
            return ($countPush > 0) ? true : false;
        }
        return false;
    }

    /**
     * @param $device
     * @param $message
     * @param $arrayData
     * @param $pushLog
     * @param $enableResendPush
     */
    public static function resendPushNotification($device, $message, $arrayData, $pushLog, $enableResendPush)
    {
        if ($enableResendPush == 1) {
            for ($i = 0; $i <= 2; $i++) {
                $push = Push::sendPushNotification($device->token_device, $message, $device->operative_system, $arrayData);
                if ($push) {
                    if (!is_null($pushLog)) {
                        $pushLog->update(['message'=> 'Push sent', 'level' => 'info', 'status' => 'sent',
                            'attempts' => (int)$pushLog->attempts + $i]);
                    }
                    break;
                } else {
                    if (!is_null($pushLog)) {
                        $pushLog->update(['level' => 'error', 'attempts' => (int)$pushLog->attempts + $i]);
                    }
                }
            }
        }
        return;
    }

    /**
     * @param $push
     * @param $device
     * @param $message
     * @param $rentalRequest
     * @param $enablePushLog
     * @return $this|PushLog|null
     */
    public static function createPushLog($push, $device, $message, $rentalRequest, $enablePushLog)
    {
        $pushLog = null;
        if ($enablePushLog == 1) {
            $pushLog = new PushLog();
            $pushLog = $pushLog->loadCreateData($push, $device, $message, $rentalRequest);
            if ($pushLog->save()) {
                $pushLog = $pushLog;
            }
        }
        return $pushLog;
    }

}
