<?php

namespace App\Http\Controllers\User;

use App\Models\CareerInfo;
use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class CareerInfoController extends Controller
{
    public function careerInfoCreate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'designation' => 'required',
            'company' => 'required',
            'start' => 'required'
        ];
        $message = [
            'designation.required' => 'Designation field is required',
            'company.required' => 'Company field is required',
            'start.required' => 'Start Date field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('careerInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = new CareerInfo();
        $data->user_id = auth()->user()->id;
        $data->designation = $req['designation'];
        $data->company = $req['company'];
        $data->start = $req['start'];
        $data->end = $req['end'] ? $req['end'] : NULL;

        $data->save();

        $career_info = ProfileInfo::firstOrNew([
            'user_id' => auth()->user()->id,
        ]);
        $career_info->career_info = 1;
        $career_info->save();

        session()->put('name','careerInfo');

        return back()->with('success', 'Career Info Added Successfully.');
    }


    public function careerInfoUpdate(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'designation' => 'required',
            'company' => 'required',
            'start' => 'required'
        ];
        $message = [
            'designation.required' => 'Designation field is required',
            'company.required' => 'Company field is required',
            'start.required' => 'Start Date field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('careerInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = CareerInfo::findOrFail($id);
        $data->user_id = auth()->user()->id;
        $data->designation = $req['designation'];
        $data->company = $req['company'];
        $data->start = $req['start'];
        $data->end = $req['end'] ? $req['end'] : NULL;

        $data->save();

        session()->put('name','careerInfo');

        return back()->with('success', 'Career Info Updated Successfully.');
    }


    public function careerInfoDelete($id)
    {
        $data = CareerInfo::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Career Info has been deleted');
    }

}
