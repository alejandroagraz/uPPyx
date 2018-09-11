<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\City;
use App\Models\Charge;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\CarClassification;

class ChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charges = Charge::with('configuration')->get();
        return view('charges.list-charges')->with('charges', $charges);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $countries = Country::all();
        $configTypes = Configuration::where('type', 'charge')->get();
        $carClassification = CarClassification::all();

        return view('charges.register-charges')->with('countries',$countries)
                                                ->with('configTypes',$configTypes)
                                                ->with('carClassification',$carClassification);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $num = count($data['car_classification']);
        $message = "Algunos datos no fueron registrados porque ya existen, en particular: '";
        $error=0;

        for($i=0; $i < $num; $i++){
            $exists = Charge::where('configuration_id', $data['configuration_id'][$i])
                                    ->where('car_classification_id', $data['car_classification'][$i])
                                    ->first();
            if(!$exists){
                $configuration = new Charge;
                $configuration->car_classification_id = $data['car_classification'][$i];
                $configuration->configuration_id = $data['configuration_id'][$i];
                $configuration->save();
            }
            else{
                $message .= $data['configuration_name'][$i]."' para: ".$data['car_name'][$i]."' ";
                $error=1;
            }
        }
        if($error==1){
            return redirect()->back()->with('message_type', 'danger')->with('status', $message);
        }
        else {
            return redirect()->route('charges.index')->with('message_type', 'success')->with('status', 'Cargo Guardado Exitosamente!');
        }
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function citiesSelect($country_id)
    {
        $cities = City::where('country_id', '=', $country_id)->get(['id', 'name']);
        return $cities;
    }

    /**
     * @param $country_id
     * @param $city_id
     * @return mixed
     */
    public function chargesSelect($country_id,$city_id)
    {
        if ($city_id == "0") {
            $city_id = null;
        }
        $configuration = Configuration::where('type', '=', 'charge')->where('country_id', $country_id)->where('city_id', $city_id)->get();
        return $configuration;

    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $charge = Charge::find($id);
        $countries = Country::all();
        $cities = City::all();
        $configTypes = Configuration::where('type', 'charge')->with('countryConfig')->with('cityConfig')->get();
        $carClassification = CarClassification::all();
        return view('charges.update-charges')->with('charge',$charge)
                                            ->with('countries',$countries)
                                            ->with('cities',$cities)
                                            ->with('configTypes',$configTypes)
                                            ->with('carClassification',$carClassification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exists = Charge::where('id', '!=', $request->id)->first();

        if($exists->configuration_id == $request->configuration_id) {
            $cfg = Charge::find($request->id);
            $cfg->car_classification_id = $request->car_classification;
            $cfg->configuration_id = $request->configuration_id;
            $cfg->save();

            return redirect()->route('charges.index')->with('message_type', 'success')->with('status', 'Configuración Actualizada!');
        }
        else{
            $message = "Ya existe un registro con esta información";
            return redirect()->back()->with('message_type', 'danger')->with('status', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = Charge::find($id);
        if($charge){
            $charge->delete();
        }
        return redirect('/list-charges')->with('message_type', 'success')->with('status', 'Configuración Eliminada!');
    }
}
