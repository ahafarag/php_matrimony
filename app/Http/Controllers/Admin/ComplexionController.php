<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Complexion;
use Illuminate\Http\Request;
use App\Models\ComplexionDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class ComplexionController extends Controller
{
    public function complexionList(){
        $complexion = Complexion::with('details')->latest()->get();
        return view('admin.complexion.complexionList', compact('complexion'));
    }


    public function complexionCreate(){
        $languages = Language::all();
        return view('admin.complexion.complexionCreate', compact('languages'));
    }

    public function complexionStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:complexion_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This complexion name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $complexion = new Complexion();
        $complexion->save();

        $complexion->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.complexionList')->with('success', 'Complexion Saved Successfully');
    }


    public function complexionEdit($id){
        $languages           = Language::all();
        $complexionDetails = ComplexionDetails::with('complexion')->where('complexion_id', $id)->get()->groupBy('language_id');

        return view('admin.complexion.complexionEdit', compact('languages', 'complexionDetails', 'id'));
    }



    public function complexionUpdate(Request $request, $id, $language_id){

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

        $complexion = Complexion::findOrFail($id);
        $complexion->save();

        $complexion->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.complexionList')->with('success', 'Complexion Successfully Updated');
    }


    public function complexionDelete($id){
        $complexion = Complexion::findOrFail($id);
        $complexion->delete();
        return back()->with('success', 'Complexion has been deleted');
    }
    
}
