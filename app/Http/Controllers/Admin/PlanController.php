<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use App\Models\Plan;
use App\Models\Language;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\PlanDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use Upload, Notify;

    public function plan()
    {
        $managePlans = Plan::with('details')->latest()->get();
        return view('admin.plan.planList', compact('managePlans'));
    }

    public function planCreate()
    {
        $languages = Language::all();
        return view('admin.plan.planCreate', compact('languages'));
    }


    public function planStore(Request $request, $language)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name.*' => 'required|max:191',
            'price' => 'required|numeric',
            'icon' => 'required',
            'express_interest' => 'required',
            'gallery_photo_upload' => 'required',
            'contact_view_info' => 'required',
        ];
        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.max' => 'This field may not be greater than :max characters.',
            'price.required' => 'Price field is required',
            'price.numeric' => 'Price must be a numeric value',
            'icon.required' => 'Select an Icon',
            'express_interest.required' => 'Express Interest field is required',
            'gallery_photo_upload.required' => 'Gallery Photo Upload field is required',
            'contact_view_info.required' => 'Profile Info View field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $plan = new Plan();
        $plan->price = $purifiedData['price'];
        $plan->icon = $purifiedData['icon'];
        $plan->status = (int) $purifiedData['status'];
        $plan->show_auto_profile_match = (int) $purifiedData['show_auto_profile_match'];
        $plan->express_interest = $purifiedData['express_interest'];
        $plan->express_interest_status = (int) $purifiedData['express_interest_status'];
        $plan->gallery_photo_upload = $purifiedData['gallery_photo_upload'];
        $plan->gallery_photo_upload_status = (int) $purifiedData['gallery_photo_upload_status'];
        $plan->contact_view_info = $purifiedData['contact_view_info'];
        $plan->contact_view_info_status = (int) $purifiedData['contact_view_info_status'];

        $plan->save();

        $plan->details()->create([
            'language_id' => $language,
            'name' => $purifiedData["name"][$language],
        ]);

        return redirect()->route('admin.planList')->with('success', 'Package Successfully Saved');

    }


    public function planDelete($id)
    {
        $planPurchasedExist = Fund::where('plan_id', $id)->where('status', 1)->exists();
        if ($planPurchasedExist){
            return back()->with('error', 'Can\'t delete this Package, because this Package is already purchased by user');
        }
        else{
            $planData = Plan::findOrFail($id);
            $planData->delete();
            return back()->with('success', 'Package has been deleted');
        }

    }


    public function planEdit($id)
    {
        $languages = Language::all();
        $planDetails = PlanDetails::with('Plan')->where('plan_id', $id)->get()->groupBy('language_id');
        $detailsCount = PlanDetails::where('plan_id', $id)->first();
        return view('admin.plan.planEdit', compact('languages', 'planDetails', 'id', 'detailsCount'));
    }


    public function planUpdate(Request $request, $id, $language_id)
    {
        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        $rules = [
            'name.*' => 'required|max:191',
            'price' => 'sometimes|required|numeric',
            'icon' => 'sometimes|required',
            'express_interest' => 'sometimes|required',
            'gallery_photo_upload' => 'sometimes|required',
            'contact_view_info' => 'sometimes|required',
        ];
        $message = [
            'name.*.required' => 'Name field is required',
            'name.*.max' => 'This field may not be greater than :max characters.',
            'price.required' => 'Price field is required',
            'price.numeric' => 'Price must be a numeric value',
            'icon.required' => 'Select an Icon',
            'express_interest.required' => 'Express Interest field is required',
            'gallery_photo_upload.required' => 'Gallery Photo Upload field is required',
            'contact_view_info.required' => 'Profile Info View field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }


        $plan = Plan::findOrFail($id);

        if($request->has('price')){
            $plan->price =$purifiedData['price'];
        }

        if($request->has('icon')){
            $plan->icon = $purifiedData['icon'];
        }
        if($request->has('status')){
            $plan->status = (int) $purifiedData['status'];
        }

        if($request->has('show_auto_profile_match')){
            $plan->show_auto_profile_match = (int) $purifiedData['show_auto_profile_match'];
        }
        if($request->has('express_interest')){
            $plan->express_interest = $purifiedData['express_interest'];
        }
        if($request->has('express_interest_status')){
            $plan->express_interest_status = (int) $purifiedData['express_interest_status'];
        }
        if($request->has('gallery_photo_upload')){
            $plan->gallery_photo_upload = $purifiedData['gallery_photo_upload'];
        }
        if($request->has('gallery_photo_upload_status')){
            $plan->gallery_photo_upload_status = (int) $purifiedData['gallery_photo_upload_status'];
        }
        if($request->has('contact_view_info')){
            $plan->contact_view_info = $purifiedData['contact_view_info'];
        }
        if($request->has('contact_view_info_status')){
            $plan->contact_view_info_status = (int) $purifiedData['contact_view_info_status'];
        }

        $plan->save();

        $plan->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'name' => $purifiedData["name"][$language_id]
            ]
        );

        return redirect()->route('admin.planList')->with('success', 'Package Successfully Updated');
    }


    public function soldPlanList()
    {
        $soldPlans = Fund::with('allPlan', 'user:id,firstname,lastname,username,image')->where('status', 1)->where('plan_id',"!=", null)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));

        return view('admin.soldPlan.soldPlan', compact('soldPlans'));
    }


    public function soldPlanSearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $soldPlans = Fund::with('planDetails.plan', 'user:id,firstname,lastname,username,email,image')->where('status', 1)->where('plan_id',"!=", null)->orderBy('id', 'DESC')
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('firstname', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('lastname', 'LIKE', "%{$search['user_name']}%");
                });
            })
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->whereHas('planDetails', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['name']}%");
                });
            })
            ->when(isset($search['price']), function ($query) use ($search) {
                return $query->whereHas('planDetails.plan', function ($q) use ($search) {
                    $q->where('price', $search['price']);
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));

        $soldPlans =  $soldPlans->appends($search);

        return view('admin.soldPlan.soldPlan', compact('soldPlans'));
    }




}
