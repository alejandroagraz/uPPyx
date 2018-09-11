<?php

use App\Models\LogType;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Seeder;

class LogsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'sent_request',
                'description' => 'Solicitud Enviada'
            ],
            [
                'name' => 'accepted_request',
                'description' => 'Solicitud Aceptada'
            ],
            [
                'name' => 'took_request',
                'description' => 'Agente Asignado'
            ],
            [
                'name' => 'routed_request',
                'description' => 'Agente en Camino'
            ],
            [
                'name' => 'checked_request',
                'description' => 'Documentos Revisados'
            ],
            [
                'name' => 'boarded_request',
                'description' => 'Cliente a Bordo'
            ],
            [
                'name' => 'returned_request',
                'description' => 'Vehículo Devuelto'
            ],
            [
                'name' => 'finished_request',
                'description' => 'Solictud Finalizada'
            ],
            [
                'name' => 'extended_request',
                'description' => 'Solictud Extendida'
            ],
            [
                'name' => 'rejected_request',
                'description' => 'Solicitud Cancelada'
            ],
            [
                'name' => 'system_cancelled_request',
                'description' => 'Solicitud Cancelada (Sistema)'
            ],
            [
                'name' => 'user_cancelled_request',
                'description' => 'Solicitud Cancelada (Usuario)'
            ],
            [
                'name' => 'uncategorized_log_request',
                'description' => 'Log Sin Categorizar'
            ]
        ];

        for ($i = 0; $i < count($data); $i++) {
            $exists = LogType::whereName($data[$i]['name'])->first();
            if (!$exists) {
                $model = new LogType();
                $model->uuid = Uuid::generate(4)->string;
                $model->name = $data[$i]['name'];
                $model->description = $data[$i]['description'];
                $model->save();
            } else {
                $exists->name = $data[$i]['name'];
                $exists->description = $data[$i]['description'];
                $exists->save();
            }
        }
    }
}
