<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Interest;
use App\Models\Religion;
use App\Http\Traits\Notify;
use Illuminate\Http\Request;
use App\Models\PurchasedPlanItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    use Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    public function updateInterest(Request $request, $member_id){

        $user_id = Auth::id();

        $member_profile = User::where('id', $member_id)->first();

        if($request->ajax()){
            $data = $request->all();
            $countInterest = Interest::where([
                                    'user_id' => $user_id,
                                    'member_id' => $member_id
                                ])->count();
        }


        $interestExist = PurchasedPlanItem::select('express_interest')->where('user_id', $user_id)->first();


        if(isset($interestExist) && $interestExist->express_interest > 0){
            $interestList = new Interest();
            if($countInterest == 0){
                $interestList->member_id = $data['member_id'];
                $interestList->user_id = $user_id;
                $interestList->save();

                $interestDecrement = PurchasedPlanItem::where('user_id', $user_id)->decrement('express_interest');

                $this->sendMailSms($member_profile, $type = 'MAKE_INTEREST', [
                    'username' => $this->user->username,
                    'profileUrl' => '<a href="' . route('user.member.profile.show', $this->user->id) . '" target="_blank">click here</a>'
                ]);

                $msg = [
                    'username' => $this->user->username,
                    'profileUrl' => route('user.member.profile.show', $this->user->id)
                ];
                $action = [
                    "link" => route('user.member.profile.show', $this->user->id),
                    "icon" => "fas fa-money-bill-alt text-white"
                ];
                $this->userPushNotification($member_profile, 'MAKE_INTEREST', $msg, $action);

                return response()->json(['action' => 'add', 'message'=>'You Have Expressed Interest To This Member']);
            }else{
                return response()->json(['action' => 'alreadyExist', 'message'=>'You Have Already Expressed Interest To This Member']);
            }
        }
        else{
            return response()->json(['action' => 'purchasePackage', 'message'=>'Please Update Your Package']);
        }

    }


    public function interestListShow(){
        $data['interestList'] = Interest::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.interestList.interestList', $data);
    }


    public function interestListDelete($id){
        $interestList = Interest::findOrFail($id);
        $interestList->delete();
        return back()->with('success', 'You Have Removed This Member From Your Interest List');
    }


    public function interestListSearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $data['interestList'] = Interest::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('firstname', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('lastname', 'LIKE', "%{$search['user_name']}%");
                });
            })
            ->when(isset($search['age']), function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('age', $search['age']);
                });
            })
            ->when(isset($search['religion']), function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('religion', $search['religion']);
                });
            })
            ->paginate(config('basic.paginate'));

        $data['interestList']->appends($search);

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.interestList.interestList', $data);
    }


}
