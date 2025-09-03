<?php

namespace App\Http\Controllers\User;

use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class EducationInfoController extends Controller
{
    public function educationInfoCreate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'degree' => 'required',
            'institution' => 'required',
            'start' => 'required',
            'end' => 'required'
        ];
        $message = [
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
            'start.required' => 'Start Date field is required',
            'end.required' => 'End Date field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('educationInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = new EducationInfo();
        $data->user_id = auth()->user()->id;
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];

        $data->save();

        $education_info = ProfileInfo::firstOrNew([
            'user_id' => auth()->user()->id,
        ]);
        $education_info->education_info = 1;
        $education_info->save();

        session()->put('name','educationInfo');

        return back()->with('success', 'Education Info Added Successfully.');
    }


    public function educationInfoUpdate(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'degree' => 'required',
            'institution' => 'required',
            'start' => 'required',
            'end' => 'required'
        ];
        $message = [
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
            'start.required' => 'Start Date field is required',
            'end.required' => 'End Date field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('educationInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = EducationInfo::findOrFail($id);
        $data->user_id = auth()->user()->id;
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];

        $data->save();

        session()->put('name','educationInfo');

        return back()->with('success', 'Education Info Updated Successfully.');
    }


    public function educationInfoDelete($id)
    {
        $data = EducationInfo::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Education Info has been deleted');
    }

}
