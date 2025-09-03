<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CommunityValue;
use App\Http\Controllers\Controller;
use App\Models\CommunityValueDetails;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class CommunityValueController extends Controller
{
    public function communityValueList(){
        $communityValue = CommunityValue::with('details')->latest()->get();
        return view('admin.communityValue.communityValueList', compact('communityValue'));
    }


    public function communityValueCreate(){
        $languages = Language::all();
        return view('admin.communityValue.communityValueCreate', compact('languages'));
    }

    public function communityValueStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:community_value_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Community Value name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $communityValue = new CommunityValue();
        $communityValue->save();

        $communityValue->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.communityValueList')->with('success', 'Community Value Saved Successfully');
    }


    public function communityValueEdit($id){
        $languages           = Language::all();
        $communityValueDetails = CommunityValueDetails::with('communityValue')->where('community_value_id', $id)->get()->groupBy('language_id');

        return view('admin.communityValue.communityValueEdit', compact('languages', 'communityValueDetails', 'id'));
    }



    public function communityValueUpdate(Request $request, $id, $language_id){

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

        $communityValue = CommunityValue::findOrFail($id);
        $communityValue->save();

        $communityValue->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.communityValueList')->with('success', 'Community Value Successfully Updated');
    }


    public function communityValueDelete($id){
        $communityValue = CommunityValue::findOrFail($id);
        $communityValue->delete();
        return back()->with('success', 'Community Value has been deleted');
    }

}
