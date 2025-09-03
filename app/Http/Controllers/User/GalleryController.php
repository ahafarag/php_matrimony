<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Gallery;
use Illuminate\Support\Facades\File;
use App\Models\PurchasedPlanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class GalleryController extends Controller
{
    use Upload;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    public function galleryList(){
        $data['galleryList'] = Gallery::where('user_id', auth()->user()->id)->latest()->get();
        $data['purchasedPlanItems'] = PurchasedPlanItem::where('user_id',$this->user->id)->select('gallery_photo_upload')->first();

        return view($this->theme . 'user.gallery.index', $data);
    }


    public function galleryCreate(){
        return view($this->theme . 'user.gallery.create');
    }


    public function galleryStore(Request $request){

        $galleryExist = PurchasedPlanItem::select('gallery_photo_upload')->where('user_id', $this->user->id)->first();

        if(isset($galleryExist) && $galleryExist->gallery_photo_upload > 0){
            $userData = Purify::clean($request->except('image', '_token', '_method'));

            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }

            $rules = [
                'image' => 'sometimes|image|max:3072|mimes:jpg,jpeg,png',
            ];
            $message = [
                'image.required' => 'Image is required',
                'image.mimes' => 'This image must be a file of type: jpg, jpeg, png.',
                'image.max' => 'This image may not be greater than :max kilobytes.',
            ];

            $Validator = Validator::make($userData, $rules, $message);

            if ($Validator->fails()) {
                return back()->withErrors($Validator)->withInput();
            }

            if ($request->hasFile('image')) {
                try {
                    $user = new Gallery();
                    $user->user_id = auth()->user()->id;
                    $user->image  = $this->uploadImage($request->image, config('location.gallery.path'), null, null, config('location.gallery.thumb_size'));

                    $user->save();

                    $galleryDecrement = PurchasedPlanItem::where('user_id', $this->user->id)->decrement('gallery_photo_upload');

                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }
        }
        else{
            return redirect()->route('plan')->with('error', 'Please update your package');
        }

        return back()->with('success', 'Image Uploaded Successfully.');
    }


    public function galleryDelete($id){

        $gallery = Gallery::findOrFail($id);

        $galleryImageDelete = config('location.gallery.path').$gallery->image;
        if(File::exists($galleryImageDelete)){
            File::delete($galleryImageDelete);
        }

        $galleryThumbImageDelete = config('location.gallery.path').'thumb_'.$gallery->image;
        if (File::exists($galleryThumbImageDelete)) {
            File::delete($galleryThumbImageDelete);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Gallery Image Successfully Deleted');
    }



}
