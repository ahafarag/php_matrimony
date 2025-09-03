<?php

namespace App\Http\Controllers\User;

use App\Models\Ignore;
use App\Models\Religion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IgnoreController extends Controller
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


    public function ignoreMember(Request $request, $member_id){

        if($request->ajax()){
            $data = $request->all();
        }

        $ignoreList = new Ignore();
        $ignoreList->member_id = $data['member_id'];
        $ignoreList->user_id = Auth::id();
        $ignoreList->save();

        return response()->json(['action' => 'add', 'message'=>'You Have Ignored This Member, You Will Not See This Profile Again.']);
    }


    public function ignoreListShow(){
        $data['ignoreList'] = Ignore::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.ignoreList.ignoreList', $data);
    }


    public function ignoreListDelete($id){
        $ignoreList = Ignore::findOrFail($id);
        $ignoreList->delete();
        return back()->with('success', 'You Have Removed This Member From Your Ignore List');
    }



    public function ignoreListSearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $data['ignoreList'] = Ignore::with('user:id,firstname,lastname,username,email,image,age,religion,present_country')->where('user_id', $this->user->id)->orderBy('id', 'DESC')
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

        $data['ignoreList']->appends($search);

        $data['religion'] = Religion::latest()->get();

        return view($this->theme . 'user.ignoreList.ignoreList', $data);
    }


}
