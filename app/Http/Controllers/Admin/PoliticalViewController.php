<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\PoliticalView;
use App\Http\Controllers\Controller;
use App\Models\PoliticalViewDetails;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PoliticalViewController extends Controller
{
    public function politicalViewList(){
        $politicalView = PoliticalView::with('details')->latest()->get();
        return view('admin.politicalView.politicalViewList', compact('politicalView'));
    }


    public function politicalViewCreate(){
        $languages = Language::all();
        return view('admin.politicalView.politicalViewCreate', compact('languages'));
    }

    public function politicalViewStore(Request $request, $language){
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:20|unique:political_view_details,name',
        ];

        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.unique' => 'This political view name has already been taken',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $politicalView = new PoliticalView();
        $politicalView->save();

        $politicalView->details()->create([
            'language_id' => $language,
            'name'        => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.politicalViewList')->with('success', 'Political View Saved Successfully');
    }


    public function politicalViewEdit($id){
        $languages           = Language::all();
        $politicalViewDetails = PoliticalViewDetails::with('politicalView')->where('political_view_id', $id)->get()->groupBy('language_id');

        return view('admin.politicalView.politicalViewEdit', compact('languages', 'politicalViewDetails', 'id'));
    }



    public function politicalViewUpdate(Request $request, $id, $language_id){

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

        $politicalView = PoliticalView::findOrFail($id);
        $politicalView->save();

        $politicalView->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id],
            ]
        );

        return redirect()->route('admin.politicalViewList')->with('success', 'Political View Successfully Updated');
    }


    public function politicalViewDelete($id){
        $politicalView = PoliticalView::findOrFail($id);
        $politicalView->delete();
        return back()->with('success', 'Political View has been deleted');
    }

}
