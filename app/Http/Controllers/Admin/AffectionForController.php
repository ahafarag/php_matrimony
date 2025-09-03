<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\AffectionFor;
use Illuminate\Http\Request;
use App\Models\AffectionForDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class AffectionForController extends Controller
{
    public function affectionForList(){
        $affectionFor = AffectionFor::with('details')->latest()->get();
        return view('admin.affectionFor.affectionForList', compact('affectionFor'));
    }


    public function affectionForCreate(){
        $languages = Language::all();
        return view('admin.affectionFor.affectionForCreate', compact('languages'));
    }

    public function affectionForStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:affection_for_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $affectionFor = new AffectionFor();
        $affectionFor->save();

        $affectionFor->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.affectionForList')->with('success', 'Affection For Saved Successfully');
    }


    public function affectionForEdit($id){
        $languages           = Language::all();
        $affectionForDetails = AffectionForDetails::with('affectionFor')->where('affection_for_id', $id)->get()->groupBy('language_id');

        return view('admin.affectionFor.affectionForEdit', compact('languages', 'affectionForDetails', 'id'));
    }



    public function affectionForUpdate(Request $request, $id, $language_id){

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

        $affectionFor = AffectionFor::findOrFail($id);
        $affectionFor->save();

        $affectionFor->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.affectionForList')->with('success', 'Affection For Successfully Updated');
    }


    public function affectionForDelete($id){
        $affectionFor = AffectionFor::findOrFail($id);
        $affectionFor->delete();
        return back()->with('success', 'Affection For has been deleted');
    }

}
