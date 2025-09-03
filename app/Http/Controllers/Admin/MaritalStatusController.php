<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MaritalStatus;
use App\Models\MaritalStatusDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class MaritalStatusController extends Controller
{
    public function maritalStatusList(){
        $maritalStatus = MaritalStatus::with('details')->latest()->get();
        return view('admin.maritalStatus.maritalStatusList', compact('maritalStatus'));
    }


    public function maritalStatusCreate(){
        $languages = Language::all();
        return view('admin.maritalStatus.maritalStatusCreate', compact('languages'));
    }


    public function maritalStatusStore(Request $request, $language){
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

        $maritalStatus = new MaritalStatus();
        $maritalStatus->save();

        $maritalStatus->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.maritalStatusList')->with('success', 'Marital Status Successfully Saved');
    }


    public function maritalStatusEdit($id){
        $languages           = Language::all();
        $maritalStatusDetails = MaritalStatusDetails::with('maritalStatus')->where('marital_status_id', $id)->get()->groupBy('language_id');

        return view('admin.maritalStatus.maritalStatusEdit', compact('languages', 'maritalStatusDetails', 'id'));
    }


    public function maritalStatusUpdate(Request $request, $id, $language_id){

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

        $maritalStatus = MaritalStatus::findOrFail($id);
        $maritalStatus->save();

        $maritalStatus->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.maritalStatusList')->with('success', 'Marital Status Successfully Updated');
    }


    public function maritalStatusDelete($id){
        $maritalStatus = MaritalStatus::findOrFail($id);
        $maritalStatus->delete();
        return back()->with('success', 'Marital Status has been deleted');
    }

}
