<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caste;
use App\Models\Religion;
use App\Models\SubCaste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class ReligionController extends Controller
{

    public function religionList()
    {
        $religionList = Religion::latest()->get();
        return view('admin.religion.religionList', compact('religionList'));
    }


    public function religionCreate()
    {
        return view('admin.religion.religionCreate');
    }


    public function religionStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:25|unique:religions',
        ];
        $message = [
            'name.required' => 'Religion Name field is required',
            'name.max' => 'Religion Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $religion = new Religion();
        $religion->name = $purifiedData["name"];
        $religion->save();

        return redirect()->route('admin.religionList')->with('success', 'Religion Saved Successfully');
    }


    public function religionEdit($id)
    {
        $religionList = Religion::where('id', $id)->get();
        return view('admin.religion.religionEdit', compact('religionList', 'id'));
    }


    public function religionUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:25',
        ];
        $message = [
            'name.required' => 'Religion Name field is required',
            'name.max' => 'Religion Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $religion = Religion::findOrFail($id);
        $religion->name = $purifiedData["name"];
        $religion->save();

        return redirect()->route('admin.religionList')->with('success', 'Religion Updated Successfully');
    }


    public function religionDelete($id)
    {
        $religion = Religion::findOrFail($id);
        $religion->delete();
        return back()->with('success', 'Religion Deleted Successfully');
    }



    // Caste
    public function casteList()
    {
        $casteList = Caste::with('religion')->latest()->get();
        return view('admin.religion.casteList', compact('casteList'));
    }


    public function casteCreate()
    {
        $religionList = Religion::latest()->get();
        return view('admin.religion.casteCreate',compact('religionList'));
    }


    public function casteStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'religion_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'religion_id.required' => 'Please Select a Religion',
            'name.required' => 'Caste Name field is required',
            'name.max' => 'Caste Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $caste = new Caste();
        $caste->religion_id = $purifiedData["religion_id"];
        $caste->name = $purifiedData["name"];
        $caste->save();

        return redirect()->route('admin.casteList')->with('success', 'Caste Saved Successfully');
    }


    public function casteEdit($id)
    {
        $religionList = Religion::latest()->get();
        $casteList = Caste::with('religion')->where('id', $id)->get();
        return view('admin.religion.casteEdit', compact('casteList', 'id', 'religionList'));
    }


    public function casteUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'religion_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'religion_id.required' => 'Please Select a Religion',
            'name.required' => 'Caste Name field is required',
            'name.max' => 'Caste Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $caste = Caste::findOrFail($id);
        $caste->religion_id = $purifiedData["religion_id"];
        $caste->name = $purifiedData["name"];
        $caste->save();

        return redirect()->route('admin.casteList')->with('success', 'Caste Updated Successfully');
    }


    public function casteDelete($id)
    {
        $caste = Caste::findOrFail($id);
        $caste->delete();
        return back()->with('success', 'Caste Deleted Successfully');
    }



    // Sub-Caste
    public function subCasteList()
    {
        $subCasteList = SubCaste::with('caste.religion')->latest()->get();
        return view('admin.religion.subCasteList', compact('subCasteList'));
    }


    public function subCasteCreate()
    {
        $casteList = Caste::latest()->get();
        return view('admin.religion.subCasteCreate',compact('casteList'));
    }


    public function subCasteStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'caste_id' => 'required',
            'name' => 'required|max:25'
        ];
        $message = [
            'caste_id.required' => 'Please Select a Caste',
            'name.required' => 'Sub-caste Name field is required',
            'name.max' => 'Sub-caste Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $subCaste = new SubCaste();
        $subCaste->caste_id = $purifiedData["caste_id"];
        $subCaste->name = $purifiedData["name"];
        $subCaste->save();

        return redirect()->route('admin.subCasteList')->with('success', 'Sub-caste Saved Successfully');
    }


    public function subCasteEdit($id)
    {
        $casteList = Caste::latest()->get();
        $subCasteList = SubCaste::with('caste')->where('id', $id)->get();
        return view('admin.religion.subCasteEdit', compact('subCasteList', 'id', 'casteList'));
    }


    public function subCasteUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'caste_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'caste_id.required' => 'Please Select a Caste',
            'name.required' => 'Sub-caste Name field is required',
            'name.max' => 'Sub-caste Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $subCaste = SubCaste::findOrFail($id);
        $subCaste->caste_id = $purifiedData["caste_id"];
        $subCaste->name = $purifiedData["name"];
        $subCaste->save();

        return redirect()->route('admin.subCasteList')->with('success', 'Sub-caste Updated Successfully');
    }


    public function subCasteDelete($id)
    {
        $subCaste = SubCaste::findOrFail($id);
        $subCaste->delete();
        return back()->with('success', 'Sub-caste Deleted Successfully');
    }

}
