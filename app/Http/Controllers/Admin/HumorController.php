<?php

namespace App\Http\Controllers\Admin;

use App\Models\Humor;
use App\Models\Language;
use App\Models\HumorDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class HumorController extends Controller
{
    public function humorList(){
        $humor = Humor::with('details')->latest()->get();
        return view('admin.humor.humorList', compact('humor'));
    }


    public function humorCreate(){
        $languages = Language::all();
        return view('admin.humor.humorCreate', compact('languages'));
    }

    public function humorStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:humor_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $humor = new Humor();
        $humor->save();

        $humor->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.humorList')->with('success', 'Humor Name Saved Successfully');
    }


    public function humorEdit($id){
        $languages           = Language::all();
        $humorDetails = HumorDetails::with('humor')->where('humor_id', $id)->get()->groupBy('language_id');

        return view('admin.humor.humorEdit', compact('languages', 'humorDetails', 'id'));
    }



    public function humorUpdate(Request $request, $id, $language_id){

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

        $humor = Humor::findOrFail($id);
        $humor->save();

        $humor->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.humorList')->with('success', 'Humor Successfully Updated');
    }


    public function humorDelete($id){
        $humor = Humor::findOrFail($id);
        $humor->delete();
        return back()->with('success', 'Humor has been deleted');
    }

}
