<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuration extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'value', 'contry_id', 'city_id', 'type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryConfig()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cityConfig()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    /**
     * @param null $cityId
     * @return array
     */
    public static function getAllConfigurations($cityId = null)
    {
        $configurations = (is_null($cityId)) ? self::all() : self::whereCityId($cityId)->get();
        if (count($configurations) > 0) {
            $maxWaitTimeTimeValue = self::searchConfigurationValue($configurations, 'max_wait_time', 2, 'min');
            $taxValue = self::searchConfigurationValue($configurations, 'tax', 7, '$');
            $recoverLicenceValue = self::searchConfigurationValue($configurations, 'recover_licence', 6, '$');
            $cdwValue = self::searchConfigurationValue($configurations, 'cdw', 10, '$');
            $surchargeValue = self::searchConfigurationValue($configurations, 'surcharge', 2, '$');
            $maxDaysValue = self::searchConfigurationValue($configurations, 'max_days', 90, 'd');
            $maxDaysRefreshMapValue = self::searchConfigurationValue($configurations, 'max_days_refresh_map', 5, 'min');
            $penaltyCancelRequestValue = self::searchConfigurationValue($configurations, 'penalty_cancel_request', 20, '$');
            $blockedPercentageValue = self::searchConfigurationValue($configurations, 'blocked_percentage', 20, '%');
            $requestTypeTimeValue = self::searchConfigurationValue($configurations, 'request_type_time', 1, 'H');
            $assignPlannedRequestTimeValue = self::searchConfigurationValue($configurations, 'assign_planned_request_time', 120, 'min');
            $changePaymentMaxTimeValue = self::searchConfigurationValue($configurations, 'change_payment_max_time', 12, 'H');
            $modifyRequestMaxTimeValue = self::searchConfigurationValue($configurations, 'modify_request_max_time', 24, 'H');
            $chargePlannedRequestTimeValue = self::searchConfigurationValue($configurations, 'charge_planned_request_time', 24, 'H');
            $sendMailManagerTimeValue = self::searchConfigurationValue($configurations, 'send_mail_manager_time', 24, 'H');
            $maxDaysByRentalTimeValue = self::searchConfigurationValue($configurations, 'max_days_by_rental', 21, 'd');
            $extendsRequestTimeValue = self::searchConfigurationValue($configurations, 'extends_request_time', 24, 'H');
            $assignDropOffRequestTimeValue = self::searchConfigurationValue($configurations, 'assign_dropoff_request_time', 60, 'min');
            $enablePushLog = self::searchConfigurationValue($configurations, 'enable_push_log', 1, 'boolean');
            $enableResendPush = self::searchConfigurationValue($configurations, 'enable_resend_push', 1, 'boolean');
        } else {
            $maxWaitTimeTimeValue = self::setDefaultConfigurationValue(2, 'min');
            $taxValue = self::setDefaultConfigurationValue(7, '$');
            $recoverLicenceValue = self::setDefaultConfigurationValue(6, '$');
            $cdwValue = self::setDefaultConfigurationValue(10, '$');
            $surchargeValue = self::setDefaultConfigurationValue(2, '$');
            $maxDaysValue = self::setDefaultConfigurationValue(90, 'd');
            $maxDaysRefreshMapValue = self::setDefaultConfigurationValue(5, 'min');
            $penaltyCancelRequestValue = self::setDefaultConfigurationValue(20, '$');
            $blockedPercentageValue = self::setDefaultConfigurationValue(20, '%');
            $requestTypeTimeValue = self::setDefaultConfigurationValue(1, 'H');
            $assignPlannedRequestTimeValue = self::setDefaultConfigurationValue(120, 'min');
            $changePaymentMaxTimeValue = self::setDefaultConfigurationValue(12, 'H');
            $modifyRequestMaxTimeValue = self::setDefaultConfigurationValue(24, 'H');
            $chargePlannedRequestTimeValue = self::setDefaultConfigurationValue(24, 'H');
            $sendMailManagerTimeValue = self::setDefaultConfigurationValue(24, 'H');
            $maxDaysByRentalTimeValue = self::setDefaultConfigurationValue(21, 'd');
            $extendsRequestTimeValue = self::setDefaultConfigurationValue(24, 'H');
            $assignDropOffRequestTimeValue = self::setDefaultConfigurationValue(60, 'min');
            $enablePushLog = self::setDefaultConfigurationValue(1, 'boolean');
            $enableResendPush = self::setDefaultConfigurationValue(1, 'boolean');
        }

        $configuration = [
            'max_wait_time' => $maxWaitTimeTimeValue,
            'tax' => $taxValue,
            'recover_licence' => $recoverLicenceValue,
            'cdw' => $cdwValue,
            'surcharge' => $surchargeValue,
            'max_days' => $maxDaysValue,
            'max_days_refresh_map' => $maxDaysRefreshMapValue,
            'penalty_cancel_request' => $penaltyCancelRequestValue,
            'blocked_percentage' => $blockedPercentageValue,
            'request_type_time' => $requestTypeTimeValue,
            'assign_planned_request_time' => $assignPlannedRequestTimeValue,
            'change_payment_max_time' => $changePaymentMaxTimeValue,
            'modify_request_max_time' => $modifyRequestMaxTimeValue,
            'charge_planned_request_time' => $chargePlannedRequestTimeValue,
            'send_mail_manager_time' => $sendMailManagerTimeValue,
            'max_days_by_rental' => $maxDaysByRentalTimeValue,
            'extends_request_time' => $extendsRequestTimeValue,
            'assign_dropoff_request_time' => $assignDropOffRequestTimeValue,
            'enable_push_log' => $enablePushLog,
            'enable_resend_push' => $enableResendPush,
        ];
        return $configuration;
    }

    /**
     * @param $configurations
     * @param $key
     * @param $default
     * @param $unit
     * @return mixed
     */
    public static function searchConfigurationValue($configurations, $key, $default, $unit) {
        $object = $configurations->whereStrict('alias', $key)->first();
        $configurationObject = (count($object) > 0) ? $object : null;
        $configurationObjectValue = (!is_null($configurationObject)) ? $configurationObject->value : $default;
        $configurationObjectUnit = (!is_null($configurationObject)) ? $configurationObject->unit : $unit;
        return ["value" => (int) $configurationObjectValue, "unit" => $configurationObjectUnit];
    }

    /**
     * @param $default
     * @param $unit
     * @return array
     */
    public static function setDefaultConfigurationValue($default, $unit) {
        return ["value" => (int) $default, "unit" => $unit];
    }

    /**
     * @param null $city_id
     * @return array
     */
    public static function getPushLogConfiguration($city_id = null) {
        $configurations = self::getAllConfigurations($city_id);
        return [(int)$configurations['enable_push_log']['value'], (int)$configurations['enable_resend_push']['value']];
    }

    /**
     * @param null $city_id
     * @return array
     */
    public static function getCreateRequestConfiguration($city_id = null) {
        $configurations = self::getAllConfigurations($city_id);
        return [(int)$configurations['request_type_time']['value'],
            (int)$configurations['enable_push_log']['value'], (int)$configurations['enable_resend_push']['value']];
    }
}
