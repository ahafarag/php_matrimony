<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\HairColor;
use Illuminate\Http\Request;
use App\Models\HairColorDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class HairColorController extends Controller
{
    public function hairColorList(){
        $hairColor = HairColor::with('details')->latest()->get();
        return view('admin.hairColor.hairColorList', compact('hairColor'));
    }


    public function hairColorCreate(){
        $languages = Language::all();
        return view('admin.hairColor.hairColorCreate', compact('languages'));
    }

    public function hairColorStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:hair_color_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This hair color name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $hairColor = new HairColor();
        $hairColor->save();

        $hairColor->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.hairColorList')->with('success', 'Hair Color Saved Successfully');
    }


    public function hairColorEdit($id){
        $languages           = Language::all();
        $hairColorDetails = HairColorDetails::with('hairColor')->where('hair_color_id', $id)->get()->groupBy('language_id');

        return view('admin.hairColor.hairColorEdit', compact('languages', 'hairColorDetails', 'id'));
    }



    public function hairColorUpdate(Request $request, $id, $language_id){

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

        $hairColor = HairColor::findOrFail($id);
        $hairColor->save();

        $hairColor->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.hairColorList')->with('success', 'Hair Color Successfully Updated');
    }


    public function hairColorDelete($id){
        $hairColor = HairColor::findOrFail($id);
        $hairColor->delete();
        return back()->with('success', 'Hair Color has been deleted');
    }
}
