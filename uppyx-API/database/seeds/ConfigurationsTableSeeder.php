<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        list($city, $i) = [City::whereName('Miami')->first(), 0];
        if(count($city) > 0) {
            /* $data = [
                [
                    'name' => 'Tiempo máximo de espera para cancelar request',
                    'name_en' => 'Max wait time to cancel a request',
                    'alias' => 'max_wait_time',
                    'value' => '2',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ],
                [
                    'name' => 'Tax',
                    'name_en' => 'Tax',
                    'alias' => 'tax',
                    'value' => '7',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '$'
                ],
                [
                    'name' => 'Recuperación de Licencia',
                    'name_en' => 'Licence recovery',
                    'alias' => 'recover_licence',
                    'value' => '6',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ],
                [
                    'name' => 'Daños por colisión',
                    'name_en' => 'Collision Damage Waiver',
                    'alias' => 'cdw',
                    'value' => '10',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ],
                [
                    'name' => 'Recargo',
                    'name_en' => 'Surcharge',
                    'value' => '2',
                    'alias' => 'surcharge',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ],
                [
                    'name' => 'Días máximos de renta planificada',
                    'name_en' => 'Maximum days of planned request',
                    'alias' => 'max_days',
                    'value' => '90',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'd'
                ],
                [
                    'name' => 'Tiempo máximo para hacer refresh en el mapa indicando la ubicación del carro',
                    'name_en' => 'Max time to refresh map and show the car position',
                    'alias' => 'max_days_refresh_map',
                    'value' => '60',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'seg'
                ],
                [
                    'name' => 'Monto de penalidad por haber cancelado el request cuando el status es on-way',
                    'name_en' => 'Penalty amount for cancel request with status on-way',
                    'alias' => 'penalty_cancel_request',
                    'value' => '20',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '$'
                ],
                [
                    'name' => 'Porcentaje de monto bloqueado al momento de un request',
                    'name_en' => 'Percentage amount blocked at the time of a request',
                    'alias' => 'blocked_percentage',
                    'value' => '100',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '%'
                ],
                [
                    'name' => 'Tiempo en horas de categorización de un request',
                    'name_en' => 'Time in hours of request categorization',
                    'alias' => 'request_type_time',
                    'value' => '1',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Tiempo en minutos para asignar un request a un agente',
                    'name_en' => 'Time in minutes to assign requests to a agent',
                    'alias' => 'assign_planned_request_time',
                    'value' => '120',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ],
                [
                    'name' => 'Tiempo máximo en horas para cambiar el método de pago',
                    'name_en' => 'Max time in hours to change payment',
                    'alias' => 'change_payment_max_time',
                    'value' => '12',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Tiempo máximo en horas para modificar el request',
                    'name_en' => 'Max time in hours to modify the request',
                    'alias' => 'modify_request_max_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Tiempo mínimo en horas para cobrar un request planificado',
                    'name_en' => 'Min time in hours to charge a planned request',
                    'alias' => 'charge_planned_request_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Tiempo mínimo en horas para enviar correos a los gerentes',
                    'name_en' => 'Min time in hours to send emails to managers',
                    'alias' => 'send_mail_manager_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Días máximos por request',
                    'name_en' => 'Maximum days by request',
                    'alias' => 'max_days_by_rental',
                    'value' => '21',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'd'
                ],
                [
                    'name' => 'Número de horas antes de la fecha del dropoff para extender la solicitud',
                    'name_en' => 'Number of hours before dropoff date to extends the request',
                    'alias' => 'extends_request_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ],
                [
                    'name' => 'Tiempo en minutos para asignar un dropoff request a un agente',
                    'name_en' => 'Time in minutes to assign a dropoff request to a agent',
                    'alias' => 'assign_dropoff_request_time',
                    'value' => '60',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ],
                [
                    'name' => 'Tiempo en horas para cobrar un día extra de request',
                    'name_en' => 'Time in hours to charge an extra day request',
                    'alias' => 'extra_day_request_time',
                    'value' => '3',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]
            ]; */
            $configuration = Configuration::withTrashed()->whereAlias('max_wait_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo máximo de espera para cancelar request',
                    'name_en' => 'Max wait time to cancel a request',
                    'alias' => 'max_wait_time',
                    'value' => '2',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('tax')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tax',
                    'name_en' => 'Tax',
                    'alias' => 'tax',
                    'value' => '7',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '$'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('recover_licence')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Recuperación de Licencia',
                    'name_en' => 'Licence recovery',
                    'alias' => 'recover_licence',
                    'value' => '6',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('cdw')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Daños por colisión',
                    'name_en' => 'Collision Damage Waiver',
                    'alias' => 'cdw',
                    'value' => '10',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('surcharge')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Recargo',
                    'name_en' => 'Surcharge',
                    'value' => '2',
                    'alias' => 'surcharge',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'charge',
                    'unit' => '$'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('max_days')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Días máximos de renta planificada',
                    'name_en' => 'Maximum days of planned request',
                    'alias' => 'max_days',
                    'value' => '90',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'd'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('max_days_refresh_map')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo máximo para hacer refresh en el mapa indicando la ubicación del carro',
                    'name_en' => 'Max time to refresh map and show the car position',
                    'alias' => 'max_days_refresh_map',
                    'value' => '60',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'seg'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('penalty_cancel_request')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Monto de penalidad por haber cancelado el request cuando el status es on-way',
                    'name_en' => 'Penalty amount for cancel request with status on-way',
                    'alias' => 'penalty_cancel_request',
                    'value' => '20',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '$'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('blocked_percentage')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Porcentaje de monto bloqueado al momento de un request',
                    'name_en' => 'Percentage amount blocked at the time of a request',
                    'alias' => 'blocked_percentage',
                    'value' => '20',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => '%'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('request_type_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo en horas de categorización de un request',
                    'name_en' => 'Time in hours of request categorization',
                    'alias' => 'request_type_time',
                    'value' => '1',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('assign_planned_request_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo en minutos para asignar un request a un agente',
                    'name_en' => 'Time in minutes to assign requests to a agent',
                    'alias' => 'assign_planned_request_time',
                    'value' => '120',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('change_payment_max_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo máximo en horas para cambiar el método de pago',
                    'name_en' => 'Max time in hours to change payment',
                    'alias' => 'change_payment_max_time',
                    'value' => '12',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('modify_request_max_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo máximo en horas para modificar el request',
                    'name_en' => 'Max time in hours to modify the request',
                    'alias' => 'modify_request_max_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('charge_planned_request_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo mínimo en horas para cobrar un request planificado',
                    'name_en' => 'Min time in hours to charge a planned request',
                    'alias' => 'charge_planned_request_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('send_mail_manager_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo mínimo en horas para enviar correos a los gerentes',
                    'name_en' => 'Min time in hours to send emails to managers',
                    'alias' => 'send_mail_manager_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('max_days_by_rental')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Días máximos por request',
                    'name_en' => 'Maximum days by request',
                    'alias' => 'max_days_by_rental',
                    'value' => '21',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'd'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('extends_request_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Número de horas antes de la fecha del dropoff para extender la solicitud',
                    'name_en' => 'Number of hours before dropoff date to extends the request',
                    'alias' => 'extends_request_time',
                    'value' => '24',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'H'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('assign_dropoff_request_time')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Tiempo en minutos para asignar un dropoff request a un agente',
                    'name_en' => 'Time in minutes to assign a dropoff request to a agent',
                    'alias' => 'assign_dropoff_request_time',
                    'value' => '60',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'min'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('enable_push_log')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Boleano para activar o desactivar el registro de logs de push',
                    'name_en' => 'Boolean to enable or disable push logs',
                    'alias' => 'enable_push_log',
                    'value' => '1',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'boolean'
                ]);
                $i++;
            }
            $configuration = Configuration::withTrashed()->whereAlias('enable_resend_push')->whereCountryId($city->country_id)
                ->whereCityId($city->id)->first();
            if (!$configuration) {
                DB::table('configurations')->insert([
                    'name' => 'Boleano para activar o desactivar el reenvio de push cuando falla',
                    'name_en' => 'Boolean to enable or disable push resend when failed',
                    'alias' => 'enable_resend_push',
                    'value' => '1',
                    'country_id' => $city->country_id,
                    'city_id' => $city->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'type' => 'system',
                    'unit' => 'boolean'
                ]);
                $i++;
            }
//            $configuration = Configuration::withTrashed()->whereAlias('extra_day_request_time')->whereCountryId($city->country_id)
//                ->whereCityId($city->id)->first();
//            if(!$configuration){
//                DB::table('configurations')->insert([
//                    'name' => 'Tiempo en horas para cobrar un día extra de request',
//                    'name_en' => 'Time in hours to charge an extra day request',
//                    'alias' => 'extra_day_request_time',
//                    'value' => '3',
//                    'country_id' => $city->country_id,
//                    'city_id' => $city->id,
//                    'created_at' => date('Y-m-d H:i:s'),
//                    'type' => 'system',
//                    'unit' => 'H'
//                ]);
//                $i++;
//            }
        }
        $this->command->info($i. ' Configuration(s) were seeded');
    }
}
