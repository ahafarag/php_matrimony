<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class ReportController extends Controller
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


    public function reportSubmit(Request $request, $member_id){
        $purifiedData = Purify::clean($request->except( '_token', '_method'));

        $rules = [
            'reason' => 'required'
        ];
        $message = [
            'reason.required' => 'Report Reason field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $report = new Report();
        $report->user_id = $this->user->id;
        $report->member_id = $member_id;
        $report->reason = $purifiedData["reason"];
        $report->save();

        return redirect()->back()->with('success', 'Thank You! We have received your report.');
    }


}
