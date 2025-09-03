<?php

namespace App\Http\Controllers\User;

use App\Models\Religion;
use App\Models\Shortlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShortlistController extends Controller
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


    public function updateShortist(Request $request, $member_id){

        $user_id = Auth::id();
        if($request->ajax()){

            $data = $request->all();
            $countShortlist = Shortlist::where([
                                'user_id' => $user_id,
                                'member_id' => $member_id
                            ])->count();
        }

        $shorList = new Shortlist();
        if($countShortlist == 0){
            $shorList->member_id = $data['member_id'];
            $shorList->user_id = $user_id;
            $shorList->save();
            return response()->json(['action' => 'add', 'message'=>'You Have Shortlisted This Member']);
        }else{
            Shortlist::where(['user_id' => $user_id, 'member_id' => $data['member_id']])->delete();
            return response()->json(['action' => 'remove', 'message'=>'You Have Removed This Member From Your Shortlist']);
        }
    }


    public function shortListShow(){
        $data['shortList'] = Shortlist::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.shortlist.shortlist', $data);
    }


    public function shortListDelete($id){
        $shortList = Shortlist::findOrFail($id);
        $shortList->delete();
        return back()->with('success', 'You Have Removed This Member From Your Shortlist');
    }


    public function shortListSearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $data['shortList'] = Shortlist::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')
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

        $data['shortList']->appends($search);

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.shortlist.shortlist', $data);
    }


}
