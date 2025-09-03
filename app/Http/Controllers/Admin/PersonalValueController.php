<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\PersonalValue;
use App\Http\Controllers\Controller;
use App\Models\PersonalValueDetails;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PersonalValueController extends Controller
{
    public function personalValueList(){
        $personalValue = PersonalValue::with('details')->latest()->get();
        return view('admin.personalValue.personalValueList', compact('personalValue'));
    }


    public function personalValueCreate(){
        $languages = Language::all();
        return view('admin.personalValue.personalValueCreate', compact('languages'));
    }

    public function personalValueStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:personal_value_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Personal Value name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $personalValue = new PersonalValue();
        $personalValue->save();

        $personalValue->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.personalValueList')->with('success', 'Personal Value Saved Successfully');
    }


    public function personalValueEdit($id){
        $languages           = Language::all();
        $personalValueDetails = PersonalValueDetails::with('personalValue')->where('personal_value_id', $id)->get()->groupBy('language_id');

        return view('admin.personalValue.personalValueEdit', compact('languages', 'personalValueDetails', 'id'));
    }



    public function personalValueUpdate(Request $request, $id, $language_id){

        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:100',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $personalValue = PersonalValue::findOrFail($id);
        $personalValue->save();

        $personalValue->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.personalValueList')->with('success', 'Personal Value Successfully Updated');
    }


    public function personalValueDelete($id){
        $personalValue = PersonalValue::findOrFail($id);
        $personalValue->delete();
        return back()->with('success', 'Personal Value has been deleted');
    }

}
