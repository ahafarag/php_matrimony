<?php

namespace App\Http\Controllers\User;

use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryStateCityController extends Controller
{
    use Upload, Notify;
    
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function getCountry()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view($this->theme . 'user.profile.myprofile', $data);
    }

    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }

}
