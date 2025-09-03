<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Report;
use App\Events\ChatEvent;
use App\Models\Messenger;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\UpdateUserNotification;
use Stevebauman\Purify\Facades\Purify;
use App\Events\UpdateAdminNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MessengerController extends Controller
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


    public function sendNewMessage(Request $request, $receiver_id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'message' => 'required'
        ];
        $message = [
            'message.required' => 'Message field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $message = new Messenger();
        $message->sender_id = $this->user->id;
        $message->receiver_id = $receiver_id;
        $message->message = $purifiedData["message"];
        $message->save();

        return redirect()->back()->with('success', 'Your message has been send successfully');
    }


    public function messenger()
    {
        $data['page_title'] = 'Messages';
        return view($this->theme . 'user.messenger.messenger', $data);
    }


    public function getContacts(Request $request)
    {
        $contacts = Messenger::with('sender:id,firstname,lastname,image,chat_last_seen', 'receiver:id,firstname,lastname,image,age,height,mother_tongue,chat_last_seen')
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->latest()
            ->get()
            ->map(function ($item) {
                if ($item->sender_id == auth()->id()) {
                    return $item->receiver;
                } else {
                    return $item->sender;
                }
            })
            ->unique()
            ->values()
            ->map(function ($item) {
                $item->chat_last_message = Messenger::select('message')
                        ->where(function ($query) use ($item) {
                            $query->where(['sender_id' => $item->id, 'receiver_id' => auth()->id()]);
                        })
                        ->orWhere(function ($query) use ($item) {
                            $query->where(['sender_id' => auth()->id(), 'receiver_id' => $item->id]);
                        })
                        ->latest()->first()->makeHidden('sent_at');
                        return $item;
            })
            ->map(function ($item) {
                $item->image = getFile(config('location.user.path') . $item->image);
                return $item;
            })
            ->map(function ($item) {
                if(isset($item->chat_last_seen)){
                    $item->chat_last_seen = Carbon::parse($item->chat_last_seen)->shortRelativeDiffForHumans();
                }
                return $item;
            });


        $unreadIds = Messenger::select(DB::raw('`sender_id` as senderId, count(`sender_id`) as messages_count'))
            ->where('receiver_id', auth()->id())
            ->where('read', 0)
            ->groupBy('sender_id')
            ->get();


        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('senderId', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });

        return response()->json($contacts);
    }


    public function getMessages(Request $request, $id)
    {
        Messenger::where('sender_id', $id)->where('receiver_id', auth()->id())->update(['read' => 1]);

        $messages = Messenger::with('sender:id,firstname,lastname,image', 'receiver:id,firstname,lastname,image', 'file')
            ->where(function ($query) use ($id) {
                $query->where(['sender_id' => $id, 'receiver_id' => auth()->id()]);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where(['sender_id' => auth()->id(), 'receiver_id' => $id]);
            })
            ->get()
            ->map(function ($item) {
                $image = getFile(config('location.user.path').$item->sender->image);
                $item['sender_image'] = $image;
                return $item;
            })
            ->map(function ($item) {
                $image = getFile(config('location.user.path').$item->receiver->image);
                $item['receiver_image'] = $image;
                return $item;
            })
            ->map(function ($item) {
                if (isset($item->file[0])){
                    $file = getFile(config('location.message.path').$item->file[0]->file);
                    $item['fileImage'] = $file;
                }
                return $item;
            });

        $messages->push(auth()->user());

        return response()->json($messages);
    }


    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'file' => 'nullable|mimes:jpg,png,jpeg,PNG|max:3072',
        ]);

        $message = new Messenger();
        $message->sender_id = (string)$this->user->id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        if($request->hasFile('file')){
            $messageFile  = $this->uploadImage($request->file, config('location.message.path'));
            $message->file()->create([
                'file' => $messageFile,
            ]);
            $fileImage = getFile(config('location.message.path').$messageFile);
        } else{
            $fileImage = null;
        }
        $sender_image = getFile(config('location.user.path').$this->user->image);

        $response = [
           'sender_id' => $message->sender_id,
           'receiver_id' => $message->receiver_id,
           'message' => $message->message,
           'fileImage' => $fileImage,
           'sender_image' => $sender_image,
        ];

        ChatEvent::dispatch((object) $response);

        $member_profile = User::where('id', $request->receiver_id)->first();
        $msg = [
            'username' => $this->user->username,
        ];
        $action = [
            "link" => route('user.messenger'),
            "icon" => "fas fa-money-bill-alt text-white"
        ];
        $this->userPushNotification($member_profile, 'USER_SENT_MESSAGE', $msg, $action, $message->sender_id);

        return response()->json($response);
    }


    public function chatLeaveingTime($id)
    {
        $userLastSeen = User::where('id',$id)->update(['chat_last_seen' => Carbon::now()]);
        return response()->json($userLastSeen);
    }


    public function deletePushnotification($id)
    {
        $siteNotification = SiteNotification::where(['site_notificational_id' => Auth::id(), 'msg_sender_id' => $id])->get();
        if ($siteNotification) {
            $siteNotification->each->delete();
            event(new UpdateUserNotification(Auth::id()));
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return $data;
    }


}



