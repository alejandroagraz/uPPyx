<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\RentalRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        /** Usuario Logueado*/
        $user = Auth::user();

        /** Fecha Inicial del Sistema*/
        $requestsDate = RentalRequest::select('created_at')->orderBy('created_at','ASC')->first();
        $usersDate = User::select('created_at')->whereNotNull('rental_agency_id')
            ->whereHas('roles', function($q){
                $q->whereName('user');
            })->orderBy('created_at','ASC')->first();

        if(count($usersDate)>0 && count($requestsDate)>0){
            if($requestsDate->created_at->gt($usersDate->created_at)){
                $startDate = (count($usersDate) > 0) ? Carbon::parse($usersDate->created_at)->toDateString() :
                    Carbon::parse('first day of January ' . Carbon::now()->year)->toDateString();
            }else{
                $startDate = Carbon::parse('first day of January ' . Carbon::now()->year)->toDateString();
            }
        }else{
            $startDate = (count($requestsDate) > 0) ? Carbon::parse($requestsDate->created_at)->format('Y-m-d') :
                Carbon::parse('first day of January ' . Carbon::now()->year)->format('Y-m-d');
        }

        /** Total de Clientes Registrados*/
        $users = User::with('rentalAgencies')
            ->whereHas('roles', function($q){
                $q->whereName('user');
            })->count();

        /** Total de Request*/
        $requests = ($user->hasRole('super-admin')) ? RentalRequest::all()->count() :
                            RentalRequest::whereTakenByAgency($user->rental_agency_id)->count();

        /** Total de Request Completados*/
        $requestsCompleted = ($user->hasRole('super-admin')) ? RentalRequest::whereStatus('finished')->count() :
                            RentalRequest::whereStatus('finished')->whereTakenByAgency($user->rental_agency_id)->count();

        /** Total de Carros en Servicio*/
        $requestsOn = ($user->hasRole('super-admin')) ? RentalRequest::whereIn('status',['on-board','on-way'])->count() :
                            RentalRequest::whereIn('status',['on-board','on-way'])->whereTakenByAgency($user->rental_agency_id)->count();

        /** Total de Carros en Servicio por Agencia*/
        $requestsOnAgency = RentalRequest::with(['takenByAgency'])->select('taken_by_agency', DB::raw('count(*) as total'))
                            ->whereIn('status',['on-board','on-way'])->groupBy('taken_by_agency')->get();

        /** Total de Dias Solicitados*/
        $requestsDays = ($user->hasRole('super-admin')) ? RentalRequest::whereNotNull('taken_by_agency')->sum('total_days') :
                            RentalRequest::whereNotNull('taken_by_agency')->whereTakenByAgency($user->rental_agency_id)->sum('total_days');

        /** Total de Dias Solicitados por Agencia*/
        $requestsDaysAgency = RentalRequest::with(['takenByAgency'])->select('taken_by_agency', DB::raw('SUM(total_days) as total_days'))->whereNotNull('taken_by_agency')
                              ->groupBy('taken_by_agency')->get();

        return view('home')->with('users',json_encode($users))->with('requests',json_encode($requests))
            ->with('requestsCompleted',json_encode($requestsCompleted))->with('requestsOn',json_encode($requestsOn))
            ->with('requestsDays',$requestsDays)->with('requestsOnAgency',$requestsOnAgency)
            ->with('requestsDaysAgency',$requestsDaysAgency)->with('startDate',$startDate);
    }

    
}