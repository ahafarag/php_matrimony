<?php

namespace App\Http\Controllers\Admin;

use App\Models\BodyArt;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\BodyArtDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class BodyArtController extends Controller
{
    public function bodyArtList(){
        $bodyArt = BodyArt::with('details')->latest()->get();
        return view('admin.bodyArt.bodyArtList', compact('bodyArt'));
    }


    public function bodyArtCreate(){
        $languages = Language::all();
        return view('admin.bodyArt.bodyArtCreate', compact('languages'));
    }

    public function bodyArtStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:body_art_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Body Art name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $bodyArt = new BodyArt();
        $bodyArt->save();

        $bodyArt->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.bodyArtList')->with('success', 'Body Art Saved Successfully');
    }


    public function bodyArtEdit($id){
        $languages           = Language::all();
        $bodyArtDetails = BodyArtDetails::with('bodyArt')->where('body_art_id', $id)->get()->groupBy('language_id');

        return view('admin.bodyArt.bodyArtEdit', compact('languages', 'bodyArtDetails', 'id'));
    }



    public function bodyArtUpdate(Request $request, $id, $language_id){

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

        $bodyArt = BodyArt::findOrFail($id);
        $bodyArt->save();

        $bodyArt->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.bodyArtList')->with('success', 'Body Art Successfully Updated');
    }


    public function bodyArtDelete($id){
        $bodyArt = BodyArt::findOrFail($id);
        $bodyArt->delete();
        return back()->with('success', 'Body Art has been deleted');
    }

}
