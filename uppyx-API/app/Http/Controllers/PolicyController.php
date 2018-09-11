<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\Policy;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Validations\PolicyValidations;
use App\Transformers\PolicyTransformer;

class PolicyController extends Controller
{
    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getPolicies(Request $request)
    {
        $data = $request->all();
        $validator = PolicyValidations::getPoliciesValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        $policies = Policy::all();
        
        if ($policies) {
            return PolicyTransformer::transformCollection($policies);

        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPolicy()
    {
        return view('layouts.policy');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTerms()
    {
        return view('layouts.terms');
    }
}
