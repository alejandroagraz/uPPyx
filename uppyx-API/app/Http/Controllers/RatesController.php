<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Rate;
use App\Models\Country;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\CarClassification;
use App\Transformers\RateTransformer;
use App\Validations\RatesValidations;

class RatesController extends Controller
{
    public $prevDateTo;
    public $prevDateFrom;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = Rate::all();
        return view('rates.list-rates')->with('rates',$rates);
    }

    /**
     * Show the form for creating a new resources
     */
    public function create()
    {
        $countries = Country::all();
        $carTypes = CarClassification::get(['id', 'description']);

        return view('rates.register-rates')->with('countries',$countries)->with('carTypes',$carTypes);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data = json_decode($data['table_data']);

        /*$validator = ConfigValidations::getConfigValidation($data);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'config')
                ->withInput();
        }else{*/
            foreach ($data as $rate) {
                // TODO: add validation on solaped date
                $rates = new Rate;
                $rates->car_classification_id = $rate->car;
                $rates->valid_from = $rate->from;
                $rates->valid_to = $rate->to;
                $rates->days_from = $rate->min;
                $rates->days_to = $rate->max;
                $rates->amount = (double)$rate->amount;
                $rates->country_id = $rate->country_id;
                if ($rate->city_id == "0") {
                    $rates->city_id = null;
                } else {
                    $rates->city_id = $rate->city_id;
                }
                $rates->save();
            }
            return redirect()->route('rates.index')->with('message_type', 'success')->with('status', 'Tarifas Guardadas Exitosamente!');
        //}
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function edit($id)
    {
        $rate = Rate::find($id);
        $countries = Country::all();
        $cities = $this->citiesSelect($rate->country_id);
        $carTypes = CarClassification::get(['id', 'description']);
        return view('rates.update-rates')->with('rate',$rate)->with('countries',$countries)->with('cities',$cities)->with('carTypes',$carTypes);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $rate = Rate::find($id);
        $rate->amount = (double)$request->amount;
        $rate->save();

        return redirect()->route('rates.index')->with('message_type', 'success')->with('status', 'Tarifa Actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = Rate::find($id);
        $rate->delete();
        return redirect()->route('rates.index')->with('message_type', 'success')->with('status', 'Tarifa Eliminada!');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateDateRanges(Request $request){
        $validator = RatesValidations::validateDateRangesValidation($request);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed',200);
        }

        $validDate = $this->verifyIfDateFromIsCorrect($request);
        if(is_array($validDate)){
            return General::responseErrorAPI($validDate['message'],'invalidRange',200);
        }

        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);

        $queryAllRates = Rate::whereCarClassificationId($request->car)
            ->whereCountryId($request->country_id)
            ->where(function($query) use ($request){
                $query->whereRaw('? BETWEEN days_from AND days_to', [$request->min]);
                $query->OrWhereRaw('? BETWEEN days_from AND days_to', [$request->max]);
            })
            ->where(function($query) use ($from, $to){
                $query->whereRaw('? BETWEEN DATE(valid_from) AND DATE(valid_to)', [$from->toDateString()]);
                $query->OrWhereRaw('? BETWEEN DATE(valid_from) AND DATE(valid_to)', [$to->toDateString()]);
            });
        if($request->city_id > 0){
            $queryAllRates->whereCityId($request->city_id);
        }else{
            $queryAllRates->whereNull('city_id');
        }
        $allRates = $queryAllRates->get();

        if(count($allRates)>0){
            return General::responseSuccessAPI('taken','taken',200);
        }else{
            $save = $this->saveRates($request);
            if($save != false){
                $rate = Rate::whereId($save)->with('carRate','countryRate','cityRate')->first();
                $data = RateTransformer::transformItem($rate);
                return General::responseSuccessAPI('available', $data);

            }else{
                return General::responseErrorAPI('error saving data','error-saving', 200);
            }
        }
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function verifyIfDateFromIsCorrect(Request $request){
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);

        if($from > $to){
            return ['message'=>'La fecha de inicio debe ser mayor a la fecha fin'];
        }
        if((int)$request->min > (int)$request->max){
            return ['message'=>'El rango de días es incorrecto.'];
        }

        $car = CarClassification::find($request->car);
        $queryRate = Rate::
            whereCarClassificationId($request->car)
            ->whereCountryId($request->country_id)
            ->orderBy('valid_from', 'ASC');
        if($request->city_id > 0){
            $queryRate->whereCityId($request->city_id);
        }else{
            $queryRate->whereNull('city_id');
        }
        $lastRate = $queryRate->get();

        $initialDate = Carbon::now();

        if(count($lastRate)){
            $i=0;
            $quantity = 0;
            foreach($lastRate as $rate){
                $valid_from = Carbon::parse($rate->valid_from);
                $valid_to = Carbon::parse($rate->valid_to);
                $nextValidDate = Carbon::parse($rate->valid_to)->addDay();

                if(!($from >= $valid_from && $from <= $valid_to) && !($to >= $valid_from && $to <= $valid_to)){

                    if($i>0){

                        if($valid_from != $this->prevDateFrom && $valid_to != $this->prevDateTo){
                            if(($valid_from->diffInDays($this->prevDateTo)) > 1){
                                $nextValidDate = $this->prevDateTo;
                                    if(!(($from >= $this->prevDateTo && $from <= $valid_from) && ($to >= $this->prevDateTo && $to <= $valid_from))){
                                        return ['message'=>'Rango disponible a partir de la fecha '.$nextValidDate->addDay()->format('d-m-Y').' para el carro '.$car->description];
                                    }
                            }
                        }
                    }else{
//                        if($from->toDateString() != $initialDate->toDateString() && $initialDate->toDateString() != $valid_from->toDateString()){
//                            $date = $initialDate->format('d-m-Y');
//                            return ['message'=>'Rango disponible a partir de la fecha '.$date.' para el carro '.$car->description];
//                        }
                    }
                    $this->prevDateTo = $valid_to;
                    $this->prevDateFrom = $valid_from;
                    if($from->toDateString() != $nextValidDate->toDateString()){
                        $quantity++;
                    }
                }else{
                    $this->prevDateTo = $valid_to;
                    $this->prevDateFrom = $valid_from;
                }
                $i++;
            }
            if($quantity == count($lastRate)){
                $date = $nextValidDate->format('d-m-Y');
                return ['message'=>'Rango disponible a partir de la fecha '.$date.' para el carro '.$car->description];
            }

        }else{
            if($from->toDateString() != $initialDate->toDateString()){
                $date = $initialDate->format('d-m-Y');
                return ['message'=>'Rango disponible a partir de la fecha '.$date.' para el carro '.$car->description];
            }
        }

        $queryRate2 = Rate::
            whereCarClassificationId($request->car)
            ->whereCountryId($request->country_id)
            ->whereRaw("DATE(valid_from) = '".$from->toDateString()."'")
            ->whereRaw("DATE(valid_to) = '".$to->toDateString()."'")
            ->orderBy('days_from', 'ASC');
        if($request->city_id > 0){
            $queryRate2->whereCityId($request->city_id);
        }else{
            $queryRate2->whereNull('city_id');
        }
        $lastRate2 = $queryRate2->get();

        $count2 = 0;
        $fromDay = 1;
        $lastRangeDays = false;
        $countLastRate2 = count($lastRate2);
        if($countLastRate2>0){
            foreach($lastRate2 as $rate){
                if(($rate->days_to+1) != $request->min){
                    $count2++;
                    $fromDay = ($rate->days_to+1);
                    if($fromDay>=21){
                        $lastRangeDays = true;
                    }
                }
            }
        }else{
            if($request->min!=1){
                return ['message'=>'El rango de días debe comenzar siempre desde 1'];
            }
        }

        if($countLastRate2>0){
            if($count2 == $countLastRate2){
                if($lastRangeDays){
                    return ['message'=>'No hay rangos de días disponibles para el carro '.$car->description];
                }else{
                    return ['message'=>'El rango de días disponible es desde '.$fromDay.' hasta 21 días para el carro '.$car->description];
                }
            }
        }


        if(count($lastRate)>0){
            $i=0;
            foreach($lastRate as $rate){
                $valid_from = Carbon::parse($rate->valid_from);
                $valid_to = Carbon::parse($rate->valid_to);

                if((($request->min >= $rate->days_from && $request->min <= $rate->days_to)
                    || ($request->max >= $rate->days_from && $request->max <= $rate->days_to)
                    ) &&
                    (($request->from >= $valid_from && $request->from <= $valid_to)
                    || ($request->to >= $valid_from && $request->to <= $valid_to))
                ){
                    return ['message'=>'El rango de fecha/dias ya está tomado.'];
                }
                $i++;
            }
            return true;
        }else{
            return true;
        }

    }

    /**
     * @param Request $request
     * @return bool
     */
    public function saveRates(Request $request){

        $rates = new Rate;
        $rates->car_classification_id = $request->car;
        $rates->valid_from = $request->from;
        $rates->valid_to = $request->to;
        $rates->days_from = $request->min;
        $rates->days_to = $request->max;
        $rates->amount = (double)$request->amount;
        $rates->country_id = $request->country_id;
        if ($request->city_id == "0") {
            $rates->city_id = null;
        } else {
            $rates->city_id = $request->city_id;
        }
        if($rates->save()){
            return $rates->id;
        }else{
            return false;
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    function loadSelectedRageByCarClassification(Request $request){
        if($request->car==''){
            return General::responseSuccessAPI('notFound');
        }
        $now = Carbon::now();
        $queryLastRate = Rate::with('carRate','countryRate','cityRate')
            ->whereCarClassificationId($request->car)
            ->whereCountryId($request->country_id)
            ->where('valid_to','>',$now->toDateString())
            ->orderBy('valid_from', 'ASC');
            if($request->city_id > 0){
                $queryLastRate->whereCityId($request->city_id);
            }else{
                $queryLastRate->whereNull('city_id');
            }
        $lastRate = $queryLastRate->get();
        if(count($lastRate) > 0){
            $data = RateTransformer::transformCollection($lastRate);
            return General::responseSuccessAPI('load', $data);
        }else{
            return General::responseSuccessAPI('notFound');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeRateById(Request $request){
        $rate = Rate::whereId($request->id)->first();
        if($rate){
            $rate->forceDelete();
        }
        return General::responseSuccessAPI('deleted');
    }
}
