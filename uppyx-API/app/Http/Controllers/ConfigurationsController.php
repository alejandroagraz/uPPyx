<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Configuration;
use App\Validations\ConfigurationValidations;

class ConfigurationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = Configuration::all();
        return view('config.list-configurations')->with('config', $config);
    }

    /**
     * Show the form for creating a new resources
     */
    public function create()
    {
        $countries = Country::all();
        $configTypes = Configuration::groupBy('type')->get(['type']);

        return view('config.register-configuration')->with('countries', $countries)->with('configTypes', $configTypes);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $message = "Algunos datos no fueron registrados porque ya existen, en particular: '";
        $error = 0;

        /*$validator = ConfigValidations::getConfigValidation($data);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'config')
                ->withInput();
        }else{*/

        for ($i = 0; $i < count($data['name']); $i++) {
            $exists = Configuration::whereAlias($data['alias'][$i])->where(function ($query) use ($data, $i) {
                $query->whereCityId($data['city_id'][$i])->orWhere('city_id', null);
            })->first();

            if (!$exists) {
                $configuration = new Configuration;
                $configuration->name = $data['name'][$i];
                $configuration->name_en = $data['name_en'][$i];
                $configuration->alias = $data['alias'][$i];
                $configuration->value = $data['value'][$i];
                $configuration->country_id = $data['country_id'][$i];
                if ($data['city_id'][$i] == "0") {
                    $configuration->city_id = null;
                } else {
                    $configuration->city_id = $data['city_id'][$i];
                }
                $configuration->type = $data['type'][$i];
                $configuration->unit = $data['unit_id'][$i];

                $configuration->save();
            } else {
                $message .= $data['name'][$i] . "' ";
                $error = 1;
            }
        }
        if ($error == 1) {
            return redirect()->back()->with('message_type', 'danger')->with('status', $message);
        } else {
            return redirect()->route('configurations.index')->with('message_type', 'success')->with('status', 'Configuración Guardada Exitosamente!');
        }
    }

    /**
     * Search for all the cities of a specified country
     * @param $country_id
     * @return $cities
     */
    public function citiesSelect($country_id)
    {
        $cities = City::where('country_id', '=', $country_id)->get(['id', 'name']);
        return $cities;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cfg = Configuration::find($id);
        $countries = Country::all();
        $cities = $this->citiesSelect($cfg->country_id);
        $configTypes = Configuration::groupBy('type')->get(['type']);
        return view('config.update-configuration')->with('cfg', $cfg)->with('countries', $countries)->with('cities', $cities)->with('configTypes', $configTypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $temp = $request->city_id;
        $exists = Configuration::whereName($request->name)->whereAlias($request->alias)->where('id', '!=', $id)->where(function ($query) use ($temp) {
            $query->whereCityId($temp)->orWhere('city_id', null);
        })->first();

        $validator = ConfigurationValidations::updatedConfigurationValidation($input, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'config')->withInput();
        } else if (!$exists) {
            $cfg = Configuration::find($id);
            $cfg->name = $request->name;
            $cfg->name_en = $request->name_en;
            $cfg->value = $request->value;
            $cfg->save();

            return redirect()->route('configurations.index')->with('message_type', 'success')->with('status', 'Configuración Actualizada!');
        } else {
            $message = "Ya existe un registro con esta información";
            return redirect()->back()->with('message_type', 'danger')->with('status', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $config = Configuration::find($id);
        $config->delete();
        return redirect()->route('configurations.index')->with('message_type', 'success')->with('status', 'Configuración Eliminada!');
    }
}
