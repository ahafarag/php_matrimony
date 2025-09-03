<?php

namespace App\Http\Controllers\Admin;

use App\Models\BodyType;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\BodyTypeDetails;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class BodyTypeController extends Controller
{
    public function bodyTypeList(){
        $bodyType = BodyType::with('details')->latest()->get();
        return view('admin.bodyType.bodyTypeList', compact('bodyType'));
    }


    public function bodyTypeCreate(){
        $languages = Language::all();
        return view('admin.bodyType.bodyTypeCreate', compact('languages'));
    }

    public function bodyTypeStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:body_type_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This Body Type has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $bodyType = new BodyType();
        $bodyType->save();

        $bodyType->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.bodyTypeList')->with('success', 'Body Type Saved Successfully');
    }


    public function bodyTypeEdit($id){
        $languages           = Language::all();
        $bodyTypeDetails = BodyTypeDetails::with('bodyType')->where('body_types_id', $id)->get()->groupBy('language_id');

        return view('admin.bodyType.bodyTypeEdit', compact('languages', 'bodyTypeDetails', 'id'));
    }



    public function bodyTypeUpdate(Request $request, $id, $language_id){

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

        $bodyType = BodyType::findOrFail($id);
        $bodyType->save();

        $bodyType->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.bodyTypeList')->with('success', 'Body Type Successfully Updated');
    }


    public function bodyTypeDelete($id){
        $bodyType = BodyType::findOrFail($id);
        $bodyType->delete();
        return back()->with('success', 'Body Type has been deleted');
    }

}
