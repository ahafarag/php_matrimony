<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\ReligiousService;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use App\Models\ReligiousServiceDetails;
use Illuminate\Support\Facades\Validator;

class ReligiousServiceController extends Controller
{
    public function religiousServiceList(){
        $religiousService = ReligiousService::with('details')->latest()->get();
        return view('admin.religiousService.religiousServiceList', compact('religiousService'));
    }


    public function religiousServiceCreate(){
        $languages = Language::all();
        return view('admin.religiousService.religiousServiceCreate', compact('languages'));
    }

    public function religiousServiceStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:religious_service_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Religious Service name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $religiousService = new ReligiousService();
        $religiousService->save();

        $religiousService->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.religiousServiceList')->with('success', 'Religious Service Saved Successfully');
    }


    public function religiousServiceEdit($id){
        $languages           = Language::all();
        $religiousServiceDetails = ReligiousServiceDetails::with('religiousService')->where('religious_service_id', $id)->get()->groupBy('language_id');

        return view('admin.religiousService.religiousServiceEdit', compact('languages', 'religiousServiceDetails', 'id'));
    }



    public function religiousServiceUpdate(Request $request, $id, $language_id){

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

        $religiousService = ReligiousService::findOrFail($id);
        $religiousService->save();

        $religiousService->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.religiousServiceList')->with('success', 'Religious Service Successfully Updated');
    }


    public function religiousServiceDelete($id){
        $religiousService = ReligiousService::findOrFail($id);
        $religiousService->delete();
        return back()->with('success', 'Religious Service has been deleted');
    }


}
