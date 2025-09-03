<?php

namespace App\Services;

use Image;
use Carbon\Carbon;
use App\Models\Plan;
use App\Http\Traits\Notify;
use App\Models\Transaction;
use App\Models\PurchasedPlanItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BasicService
{
    use Notify;

    public function validateImage(object $getImage, string $path)
    {
        if ($getImage->getClientOriginalExtension() == 'jpg' or $getImage->getClientOriginalName() == 'jpeg' or $getImage->getClientOriginalName() == 'png') {
            $image = uniqid() . '.' . $getImage->getClientOriginalExtension();
        } else {
            $image = uniqid() . '.jpg';
        }
        Image::make($getImage->getRealPath())->resize(300, 250)->save($path . $image);
        return $image;
    }

    public function validateDate(string $date)
    {
        if (preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}$/", $date)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateKeyword(string $search, string $keyword)
    {
        return preg_match('~' . preg_quote($search, '~') . '~i', $keyword);
    }

    public function cryptoQR($wallet, $amount, $crypto = null)
    {

        $varb = $wallet . "?amount=" . $amount;
        return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
    }

    public function preparePaymentUpgradation($order)
    {
        $basic = (object)config('basic');
        $gateway = $order->gateway;

        if ($order->status == 0) {
            $order['status'] = 1;
            $order->update();

            $user = $order->user;
            $user->save();

            $plan_id = $order->plan_id;

            $this->makeTransaction($user, getAmount($order->amount), getAmount($order->charge), '-',  $order->transaction,  'Payment Via ' . $gateway->name, $plan_id);

            $msg = [
                'username' => $user->username,
                'amount' => getAmount($order->amount),
                'currency' => $basic->currency,
                'gateway' => $gateway->name,
                'plan_name' => optional($order->planDetails)->name
            ];
            $action = [
                "link" => route('admin.user.fundLog', $user->id),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->adminPushNotification('PLAN_PURCHASE_PAYMENT_COMPLETE', $msg, $action);
            $this->sendMailSms($user, 'PLAN_PURCHASE_PAYMENT_COMPLETE', [
                'gateway_name' => $gateway->name,
                'amount' => getAmount($order->amount),
                'charge' => getAmount($order->charge),
                'currency' => $basic->currency,
                'transaction' => $order->transaction,
                'plan_name' => optional($order->planDetails)->name
            ]);

            session()->forget('amount');
        }

    }

    /**
     * @param $user
     * @param $amount
     * @param $charge
     * @param $trx_type
     * @param $balance_type
     * @param $trx_id
     * @param $remarks
     */
    public function makeTransaction($user, $amount, $charge, $trx_type = null, $trx_id, $remarks = null, $plan_id): void
    {
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($amount);
        $transaction->charge = $charge;
        $transaction->trx_type = $trx_type;
        $transaction->final_balance = $user->balance;
        $transaction->trx_id = $trx_id;
        $transaction->remarks = $remarks;
        $transaction->save();


        // insert/updating purchased plan data into 'purchased_plan_item' table
        $plan = $plan = Plan::where('id', $plan_id)->where('status', 1)->first();
        $userId = $user->id;

        $userDataExist = PurchasedPlanItem::where('user_id',$userId)->first();

        if($userDataExist){
            $userDataExist->user_id = $userId;
            $userDataExist->show_auto_profile_match = DB::raw('show_auto_profile_match +'.$plan->show_auto_profile_match);
            $userDataExist->express_interest = DB::raw('express_interest +'.$plan->express_interest);
            $userDataExist->gallery_photo_upload = DB::raw('gallery_photo_upload +'.$plan->gallery_photo_upload);
            $userDataExist->contact_view_info = DB::raw('contact_view_info +'.$plan->contact_view_info);
            $userDataExist->save();
        }
        else{
            $freePlan = new PurchasedPlanItem();
            $freePlan->user_id = $userId;
            $freePlan->show_auto_profile_match = $plan->show_auto_profile_match;
            $freePlan->express_interest = $plan->express_interest;
            $freePlan->gallery_photo_upload = $plan->gallery_photo_upload;
            $freePlan->contact_view_info = $plan->contact_view_info;
            $freePlan->save();
        }

    }


}
