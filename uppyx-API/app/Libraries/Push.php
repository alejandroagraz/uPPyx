<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 11/30/16
 * Time: 2:33 PM
 */

namespace App\Libraries;

use Davibennun\LaravelPushNotification\Facades\PushNotification;

class Push
{
    /**
     * @param $deviceToken
     * @param $message
     * @param $os
     * @param $arrayInfo
     * @return bool
     */
    public static function sendPushNotification($deviceToken, $message, $os, $arrayInfo)
    {

        if (!$deviceToken) {
            return false;
        }
        $view = isset($arrayInfo['view']) ? $arrayInfo['view'] : '';
        $body = isset($arrayInfo['body']) ? $arrayInfo['body'] : '';
        $contentAvailable = isset($arrayInfo['content-available']) ? $arrayInfo['content-available'] : 0;
        $sent = false;
        $payload = [
            'badge' => 1,
            'sound' => 'default',
            'custom' => ['view' => $view, 'body' => $body]
//          'actionLocKey' => 'Action button title!',
//          'locKey' => $message,
//          'locArgs' => [
//              'localized args',
//              'localized args',
//          ],
//          'launchImage' => 'image.jpg',
        ];
        if ($contentAvailable !== 0) {
            $payload['badge'] = false;
            $payload['sound'] = null;
            $payload['content-available'] = $contentAvailable;
            $message = null;
        }
        $message = PushNotification::Message($message, $payload);

        if (strtolower($os) == 'ios') {
            // IOS
            if (strlen($deviceToken) == 64) {
                $sent = PushNotification::app('uPPyxiOS')
                    ->to($deviceToken)
                    ->send($message);
            } else {
                $sent = false;
            }
        } else if (strtolower($os) == 'android') {
            // Android
            if (strlen($deviceToken) >= 100) {
                $sent = PushNotification::app('uPPyxAndroid')
                    ->to($deviceToken)
                    ->send($message);
            } else {
                $sent = false;
            }
        }
        return ($sent) ? true : false;

    }

}