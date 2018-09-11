<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\RentalRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard with a custom date range.
     * @param $request
     * @return \Illuminate\View\View
     */
    public function customRange(Request $request)
    {

        $fromOrig = $request->from;
        $toOrig = $request->to;

        /** Usuario Logueado*/
        $user = Auth::user();

        /** Fecha Inicial del Sistema*/
        $requestsDate = RentalRequest::select('created_at')->orderBy('created_at','ASC')->first();
        $usersDate = User::select('created_at')->whereNotNull('rental_agency_id')
            ->whereHas('roles', function($q){$q->where('name', 'user');})->orderBy('created_at','ASC')->first();
        if($requestsDate != null && $usersDate != null) {
            if ($requestsDate->created_at->gt($usersDate->created_at)) {
                $startDate = (count($usersDate) > 0) ? Carbon::parse($usersDate->created_at)->format('d/m/Y') :
                    Carbon::parse('first day of January ' . Carbon::now()->year)->format('d/m/Y');
            } else {
                $startDate = (count($requestsDate) > 0) ? Carbon::parse($requestsDate->created_at)->format('d/m/Y') :
                    Carbon::parse('first day of January ' . Carbon::now()->year)->format('d/m/Y');
            }
        }
        else{
            $startDate = Carbon::parse('first day of January ' . Carbon::now()->year)->format('d/m/Y');
        }

        if($request->from != "" && $request->to != ""){
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);
            $to->addHours(23)->addMinutes(59)->addSeconds(59);

            /** Total de Clientes Registrados*/
            $users = User::with('rentalAgencies')->whereHas('roles', function($q){
                $q->where('name', 'user');
            })->whereBetween('created_at', array($from, $to))->count();

            /** Total de Request*/
            $requests = ($user->hasRole('super-admin')) ? RentalRequest::whereBetween('created_at', array($from, $to))->count() :
                RentalRequest::whereBetween('created_at', array($from, $to))->where('taken_by_agency', $user->rental_agency_id)->count();

            /** Total de Request Completados*/
            $requestsCompleted = ($user->hasRole('super-admin')) ? RentalRequest::where('status','finished')
                                    ->whereBetween('created_at', array($from, $to))->count() :
                                RentalRequest::where('status','finished')->whereBetween('created_at', array($from, $to))
                                    ->where('taken_by_agency', $user->rental_agency_id)->count();

            /** Total de Carros en Servicio*/
            $requestsOn = ($user->hasRole('super-admin')) ? RentalRequest::whereBetween('created_at', array($from, $to))
                                ->whereIn('status',['on-board','on-way'])->count() :
                            RentalRequest::whereBetween('created_at', array($from, $to))->whereIn('status',['on-board','on-way'])
                                ->where('taken_by_agency', $user->rental_agency_id)->count();
            /** Total de Carros en Servicio por Agencia*/
            $requestsOnAgency = RentalRequest::with(['takenByAgency'])->select('taken_by_agency', DB::raw('count(*) as total'))
                ->whereBetween('created_at', array($from, $to))->whereIn('status',['on-board','on-way'])->groupBy('taken_by_agency')->get();

            /** Total de Dias Solicitados*/
            $requestsDays = ($user->hasRole('super-admin')) ? RentalRequest::whereBetween('created_at', array($from, $to))
                                    ->whereNotNull('taken_by_agency')->sum('total_days') :
                            RentalRequest::whereBetween('created_at', array($from, $to))->whereNotNull('taken_by_agency')
                                    ->where('taken_by_agency', $user->rental_agency_id)->sum('total_days');
            /** Total de Dias Solicitados por Agencia*/
            $requestsDaysAgency = RentalRequest::with(['takenByAgency'])->select('taken_by_agency', DB::raw('SUM(total_days) as total_days'))
                ->whereBetween('created_at', array($from, $to))->whereNotNull('taken_by_agency')->groupBy('taken_by_agency')->get();

            $split = explode("|", $request->daterange);
            $daterange = (count($split) > 1) ? $split[1] : $request->daterange;
            return view('home')->with('users',$users)->with('requests',$requests)
                ->with('requestsCompleted',$requestsCompleted)->with('requestsOn',$requestsOn)
                ->with('requestsDays',$requestsDays)->with('requestsOnAgency',$requestsOnAgency)
                ->with('requestsDaysAgency',$requestsDaysAgency)->with('startDate',$startDate)
                ->with('daterange',$daterange)->with('filterSelected',$request->filterSelected)
                ->with('fromOrig',$fromOrig)->with('toOrig',$toOrig);
        }else{
            return redirect('/');
        }
    }

}
