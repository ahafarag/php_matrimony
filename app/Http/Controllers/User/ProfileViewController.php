<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Gallery;
use App\Models\Ignore;
use App\Models\MaritalStatusDetails;
use App\Models\ProfileView;
use App\Models\PurchasedPlanItem;
use App\Models\Religion;
use App\Models\Shortlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    // member view page
    public function memberProfileShow(Request $request, $member_id)
    {
        $user_id = Auth::id();


        $countProfileView = ProfileView::where([
            'user_id' => $user_id,
            'member_id' => $member_id
        ])->count();



        $profileViewExist = PurchasedPlanItem::select('contact_view_info')->where('user_id', $user_id)->first();


        if ($member_id == $user_id) {
            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();

            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";

            return view($this->theme . 'user.member.member-profile', $data);
        } elseif (isset($profileViewExist) && $profileViewExist->contact_view_info > 0 && $countProfileView == 0) {

            $profileViewList = new ProfileView();
            $profileViewList->member_id = $member_id;
            $profileViewList->user_id = $user_id;
            $profileViewList->save();

            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();

            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";

             PurchasedPlanItem::where('user_id', $user_id)->decrement('contact_view_info');

            return view($this->theme . 'user.member.member-profile', $data);
        } elseif (isset($profileViewExist) && $profileViewExist->contact_view_info >= 0 && $countProfileView != 0) {
            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();
            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";
            return view($this->theme . 'user.member.member-profile', $data);
        } else {
            return redirect()->route('plan')->with('error', 'Please update your package');
        }

    }



    // profile matched
    public function matchedProfile()
    {
        $matchedProfileExist = PurchasedPlanItem::select('show_auto_profile_match')->where('user_id', Auth::id())->first();

        if (isset($matchedProfileExist) && $matchedProfileExist->show_auto_profile_match > 0) {
            $user = Auth::user();

            $ignoreList = collect([]);

            Ignore::toBase()->where('user_id', $user->id)->select('member_id')->get()->map(function ($item) use ($ignoreList) {
                $ignoreList->push($item->member_id);
            });

            $matchedProfiles = User::with('profileInfo', 'careerInfo', 'purchasedPlanItems')
                ->whereHas('profileInfo', function ($query) {
                    return $query->where('status', 1);
                })
                ->whereNotIn('id', $ignoreList)
                ->where('id', '!=', $user->id)
                ->when(isset($user->partner_min_height), function ($query) use ($user) {
                    return $query->where('height', '>=', $user->partner_min_height);
                })
                ->when(isset($user->partner_max_weight), function ($query) use ($user) {
                    return $query->where('weight', '<=', $user->partner_max_weight);
                })
                ->when(isset($user->partner_marital_status), function ($query) use ($user) {
                    return $query->where('marital_status', $user->partner_marital_status);
                })
                ->when(isset($user->partner_religion), function ($query) use ($user) {
                    return $query->where('religion', $user->partner_religion);
                })
                ->when(isset($user->partner_preferred_country), function ($query) use ($user) {
                    return $query->where('permanent_country', $user->partner_preferred_country);
                })
                // ->when(isset($user->partner_preferred_state), function ($query) use ($user) {
                //     return $query->where('permanent_state', 'LIKE', "%" . $user->permanent_state . "%");
                // })
                // ->when(isset($user->partner_profession), function ($query) use ($user) {
                //     return $query->whereHas('careerInfo', function ($q) use ($user) {
                //         $q->where('designation', 'LIKE', "%" . $user->partner_profession . "%");
                //     });
                // })
                ->get();

            $partnerGenders = json_decode($user->partner_gender);
            $allUser = [];
            foreach ($matchedProfiles as $profile) {
                $profilePartnerGenders = json_decode($profile->partner_gender);
                if ($user->gender == $profile->gender && in_array($user->gender, $partnerGenders) && in_array($profile->gender, $profilePartnerGenders)) {
                    $allUser[] = $profile;
                } elseif($user->gender != $profile->gender && in_array($profile->gender, $partnerGenders)){
                    $allUser[] = $profile;
                }
            }

            $allUser = paginate($allUser, $perPage = 4, $page = null, $options = ["path" => route('user.matched.profile')]);
            return view($this->theme . 'user.matched_profile.matched_profile', compact('allUser'));
        } else {
            return redirect()->route('plan')->with('error', 'Please update your package');
        }

    }


}
