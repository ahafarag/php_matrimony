<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\OnBehalf;
use App\Models\OnBehalfDetails;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class OnBehalfController extends Controller
{
    public function onBehalfList(){
        $onBehalf = OnBehalf::with('details')->latest()->get();
        return view('admin.onBehalf.onBehalfList', compact('onBehalf'));
    }


    public function onBehalfCreate(){
        $languages = Language::all();
        return view('admin.onBehalf.onBehalfCreate', compact('languages'));
    }

    public function onBehalfStore(Request $request, $language){
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

        $onBehalf = new OnBehalf();
        $onBehalf->save();

        $onBehalf->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.onBehalfList')->with('success', 'On Behalf Successfully Saved');
    }


    public function onBehalfEdit($id){
        $languages           = Language::all();
        $onBehalfDetails = OnBehalfDetails::with('onBehalf')->where('on_behalf_id', $id)->get()->groupBy('language_id');

        return view('admin.onBehalf.onBehalfEdit', compact('languages', 'onBehalfDetails', 'id'));
    }



    public function onBehalfUpdate(Request $request, $id, $language_id){

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

        $onBehalf = OnBehalf::findOrFail($id);
        $onBehalf->save();

        $onBehalf->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.onBehalfList')->with('success', 'On Behalf Successfully Updated');
    }


    public function onBehalfDelete($id){
        $onBehalf = OnBehalf::findOrFail($id);
        $onBehalf->delete();
        return back()->with('success', 'On Behalf has been deleted');
    }


}
