<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FamilyValue;
use App\Models\FamilyValueDetails;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class FamilyValueController extends Controller
{
    public function familyValueList(){
        $familyValue = FamilyValue::with('details')->latest()->get();
        return view('admin.familyValue.familyValueList', compact('familyValue'));
    }


    public function familyValueCreate(){
        $languages = Language::all();
        return view('admin.familyValue.familyValueCreate', compact('languages'));
    }


    public function familyValueStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $familyValue = new FamilyValue();
        $familyValue->save();

        $familyValue->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.familyValueList')->with('success', 'Family Value Successfully Saved');
    }


    public function familyValueEdit($id){
        $languages           = Language::all();
        $familyValueDetails = FamilyValueDetails::with('familyValue')->where('family_values_id', $id)->get()->groupBy('language_id');
        return view('admin.familyValue.familyValueEdit', compact('languages', 'familyValueDetails', 'id'));
    }


    public function familyValueUpdate(Request $request, $id, $language_id){

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

        $familyValue = FamilyValue::findOrFail($id);
        $familyValue->save();

        $familyValue->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.familyValueList')->with('success', 'Family Value Successfully Updated');
    }


    public function familyValueDelete($id){
        $familyValue = FamilyValue::findOrFail($id);
        $familyValue->delete();
        return back()->with('success', 'Family Value has been deleted');
    }

}
