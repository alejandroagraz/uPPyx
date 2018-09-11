<?php

namespace App\Http\Controllers;

use Uuids;
use Datatables;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\LogType;
use Illuminate\Http\Request;


class LogsController extends Controller
{
    /**
     * @return $this
     */
    public function listadoTabla()
    {
        $logsTypes = LogType::where('name', '<>', 'uncategorized_log_request')->get(['id', 'name']);
        return view('log.list-log')->with('logsTypes', $logsTypes);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function consultaTabla(Request $request)
    {
        $log = Log::with('logTypes')->with('users')->with('rentalAgencies')->with('rentalRequests');
        $log->select(\DB::raw("logs.*, DATE_FORMAT(logs.created_at,'%d-%m-%Y') as created_at2"));
        if ($request->from != "" && $request->to != "") {
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
            $to->addHours(23)->addMinutes(59)->addSeconds(59);
            $log->whereBetween('logs.created_at', array($from, $to));
        }
        if ($request->types > 0) {
            $log->whereIn('log_type_id', $request->types);
        }
        $log->orderBy('rental_request_id', 'asc');
        return Datatables::eloquent($log)->make(true);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function detalleTabla(Request $request)
    {
        list($i, $logArray, $initDate) = [0, [], ''];
        Carbon::setLocale('es');
        $details = Log::whereRentalRequestId($request->id)->with(['users', 'logTypes', 'rentalRequests'])
            ->orderBy('created_at', 'asc')->get();
        foreach ($details as $detail) {
            if ($i == 0) {
                $initDate = Carbon::parse($detail->full_created_at);
                $date = $initDate->format('d-m-Y H:i:s');
            } else {
                $rowDate = Carbon::parse($detail->full_created_at);
                $date = $rowDate->diffForHumans($initDate);
            }
            $logObject = collect($detail->toArray());
            $logArray[] = $logObject->merge(['created_at' => $date]);
            $i++;
        }
        return $logArray;
    }
}
