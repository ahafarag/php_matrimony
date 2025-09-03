<?php

namespace App\Http\Controllers\User;

use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Traits\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
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


    public function storyList(){
        $storyList = Story::where('user_id', auth()->user()->id)->latest()->get();
        return view($this->theme . 'user.story.index', compact('storyList'));
    }


    public function storyCreate(){
        return view($this->theme . 'user.story.create');
    }


    public function storyStore(Request $request){

        $purifiedData = Purify::clean($request->except('image', 'gallery', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }
        if ($request->has('gallery')) {
            $purifiedData['gallery'] = $request->gallery;
        }

        $rules = [
            'name' => 'required|max:30',
            'place' => 'required|max:20',
            'title' => 'required|max:191',
            'date' => 'required',
            'privacy' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|max:3072|mimes:jpg,jpeg,png',
            'gallery.*' => 'max:3072|mimes:jpg,jpeg,png',
        ];
        $message = [
            'name.required' => 'Name field is required',
            'name.max' => 'This field may not be greater than :max characters.',
            'place.required' => 'Place field is required',
            'place.max' => 'Place field may not be greater than :max characters.',
            'title.required' => 'Story Title field is required',
            'title.max' => 'Story Title field may not be greater than :max characters.',
            'privacy.required' => 'Privacy field is required',
            'image.required' => 'Image is required',
            'image.mimes' => 'This image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'This image may not be greater than :max kilobytes.',
            'gallery.*.mimes' => 'This gallery image must be a file of type: jpg, jpeg, png.',
            'gallery.*.max' => 'This gallery image may not be greater than :max kilobytes.',
            'description.required' => 'Please Add Story Description',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $story = new Story();

        $story->name = $purifiedData["name"];
        $story->user_id = auth()->user()->id;
        $story->place = $purifiedData["place"];
        $story->title = $purifiedData["title"];
        $story->date = $purifiedData["date"];
        $story->status = 0;
        $story->privacy = (int) $purifiedData["privacy"];
        $story->description = $purifiedData["description"];

        if($request->hasFile('image')){
            $story->image  = $this->uploadImage($purifiedData['image'], config('location.story.path'), config('location.story.size'), null, config('location.story.thumb_size'));
        }

        $galleries = [];

        if ($request->hasFile('gallery')) {
            try {
                $galleryImage = $request->gallery;

                foreach($galleryImage as $key =>$file){
                    $galleries[] = $this->uploadImage($file, config('location.story.path'), config('location.story.size'), null, config('location.story.thumb_size'));
                }
            } catch (\Exception $exp) {
                return back()->with('error', $exp)->withInput();
            }

            $story->gallery = $galleries;
        }

        $story->save();

        return redirect()->route('user.story')->with('success', 'Story Saved Successfully');
    }


    public function storyDelete($id){

        $story = Story::findOrFail($id);

        $storyImageDelete = config('location.story.path').$story->image;
        if(File::exists($storyImageDelete)){
            File::delete($storyImageDelete);
        }

        $storyThumbImageDelete = config('location.story.path').'thumb_'.$story->image;
        if (File::exists($storyThumbImageDelete)) {
            File::delete($storyThumbImageDelete);
        }

        $old_galleries = $story->gallery;
        $location = config('location.story.path');

        if (!empty($old_galleries)) {
            foreach($old_galleries as $file){
                @unlink($location . $file);
                @unlink($location.'thumb_'.$file);
            }
        }

        $story->delete();

        return redirect()->back()->with('success', 'Story Successfully Deleted');
    }


    public function storyEdit($id){
        $story =  Story::where('id', $id)->firstOrFail();
        return view($this->theme . 'user.story.edit', compact('story'));
    }


    public function galleryImageDelete($id, $imgDelete){
        $images = [];
        $storyGalleryImage = Story::findOrFail($id);
        $old_images = $storyGalleryImage->gallery;
        $location = config('location.story.path');

        if (!empty($old_images)) {
            foreach($old_images as $file){
                if ($file == $imgDelete) {
                    unlink($location . '/' . $file);
                    unlink($location . '/' .'thumb_'. $file);
                } elseif ($file != $imgDelete) {
                    $images[] = $file;
                }
            }
        }

        $storyGalleryImage->gallery = $images;
        $storyGalleryImage->save();

        return back()->with('success', 'Gallery image has been deleted');
    }


    public function storyUpdate(Request $request, $id){

        $purifiedData = Purify::clean($request->except('image', 'gallery', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }
        if ($request->has('gallery')) {
            $purifiedData['gallery'] = $request->gallery;
        }

        $rules = [
            'name' => 'required|max:30',
            'place' => 'required|max:20',
            'title' => 'required|max:191',
            'date' => 'required',
            'privacy' => 'required|numeric',
            'description' => 'required',
            'image' => 'sometimes|required|max:3072|mimes:jpg,jpeg,png',
            'gallery.*' => 'sometimes|max:3072|mimes:jpg,jpeg,png',
        ];
        $message = [
            'name.required' => 'Name field is required',
            'name.max' => 'This field may not be greater than :max characters.',
            'place.required' => 'Place field is required',
            'place.max' => 'Place field may not be greater than :max characters.',
            'title.required' => 'Story Title field is required',
            'title.max' => 'Story Title field may not be greater than :max characters.',
            'privacy.required' => 'Privacy field is required',
            'image.required' => 'Image is required',
            'image.mimes' => 'This image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'This image may not be greater than :max kilobytes.',
            'gallery.*.mimes' => 'This gallery image must be a file of type: jpg, jpeg, png.',
            'gallery.*.max' => 'This gallery image may not be greater than :max kilobytes.',
            'description.required' => 'Please Add Story Description',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $story = Story::findOrFail($id);

        $story->name = $purifiedData["name"];
        $story->place = $purifiedData["place"];
        $story->title = $purifiedData["title"];
        $story->date = $purifiedData["date"];
        $story->status = 0;
        $story->privacy = (int) $purifiedData["privacy"];
        $story->description = $purifiedData["description"];

        if($request->hasFile('image')){
            $story->image  = $this->uploadImage($purifiedData['image'], config('location.story.path'), config('location.story.size'), $story->image, config('location.story.thumb_size'));
        }


        $galleries = [];
        $galleries = $story->gallery;

        if ($request->hasFile('gallery')) {
            try {
                $galleryImage = $request->gallery;

                foreach($galleryImage as $key =>$file){
                    $galleries[] = $this->uploadImage($file, config('location.story.path'), config('location.story.size'), null, config('location.story.thumb_size'));
                }
            } catch (\Exception $exp) {
                return back()->with('error', $exp)->withInput();
            }

            $story->gallery = $galleries;
        }

        $story->save();

        return redirect()->route('user.story')->with('success', 'Story Updated Successfully');;
    }



}
