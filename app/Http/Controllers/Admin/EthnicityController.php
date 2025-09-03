<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Ethnicity;
use Illuminate\Http\Request;
use App\Models\EthnicityDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class EthnicityController extends Controller
{
    public function ethnicityList(){
        $ethnicity = Ethnicity::with('details')->latest()->get();
        return view('admin.ethnicity.ethnicityList', compact('ethnicity'));
    }


    public function ethnicityCreate(){
        $languages = Language::all();
        return view('admin.ethnicity.ethnicityCreate', compact('languages'));
    }

    public function ethnicityStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:ethnicity_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Ethnicity name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $ethnicity = new Ethnicity();
        $ethnicity->save();

        $ethnicity->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.ethnicityList')->with('success', 'Ethnicity Saved Successfully');
    }


    public function ethnicityEdit($id){
        $languages           = Language::all();
        $ethnicityDetails = EthnicityDetails::with('ethnicity')->where('ethnicity_id', $id)->get()->groupBy('language_id');

        return view('admin.ethnicity.ethnicityEdit', compact('languages', 'ethnicityDetails', 'id'));
    }



    public function ethnicityUpdate(Request $request, $id, $language_id){

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

        $ethnicity = Ethnicity::findOrFail($id);
        $ethnicity->save();

        $ethnicity->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.ethnicityList')->with('success', 'Ethnicity Successfully Updated');
    }


    public function ethnicityDelete($id){
        $ethnicity = Ethnicity::findOrFail($id);
        $ethnicity->delete();
        return back()->with('success', 'Ethnicity has been deleted');
    }

}
