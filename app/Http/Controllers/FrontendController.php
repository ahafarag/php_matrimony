<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Country;
use App\Models\Ignore;
use App\Models\MaritalStatusDetails;
use App\Models\Plan;
use App\Models\ProfileView;
use App\Models\PurchasedPlanItem;
use App\Models\Religion;
use App\Models\Shortlist;
use App\Models\Story;
use App\Models\Content;
use App\Models\Language;
use App\Models\Template;
use App\Models\Subscriber;
use App\Http\Traits\Notify;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use App\Models\BlogCategoryDetails;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    use Notify;

    public $user, $theme;

    public function __construct()
    {
        $this->theme = template();
    }

    public function index()
    {
        $templateSection = ['hero', 'feature', 'about-us', 'story', 'premium-member', 'package', 'testimonial', 'counter', 'blog',];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['feature', 'testimonial', 'counter', 'blog',];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['blogs'] = Blog::with('details', 'category.details')->latest()->get();

        $data['plans'] = Plan::with('details')->where('status', 1)->latest()->get();

        if(Auth::user()){
            $data['freePlan'] = PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
        }

        $data['stories'] = Story::where('status',1)->latest()->get();

        $data['premiumMembers'] = PurchasedPlanItem::with('user')->where('express_interest', '>', 0)->orWhere('gallery_photo_upload', '>', 0)->orWhere('contact_view_info', '>', 0)->latest()->get();

        return view($this->theme . 'home', $data);
    }


    public function about()
    {
        $templateSection = ['about-us', 'package', 'testimonial',];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['testimonial',];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['plans'] = Plan::with('details')->where('status', 1)->latest()->get();

        if(Auth::user()){
            $data['freePlan'] = PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
        }

        return view($this->theme . 'about', $data);
    }


    public function blog()
    {
        $data['title'] = "Blog";
        $data['allBlogs'] = Blog::with('details', 'category.details')->latest()->paginate(3);
        $data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();

        return view($this->theme . 'blog', $data);
    }


    public function blogDetails($slug = null, $id)
    {
        $data['title'] = "Blog Details";
        $data['singleBlog']    = Blog::with('details')->findOrFail($id);
        $data['thisCategory']  = BlogCategoryDetails::where('blog_category_id', $data['singleBlog']->blog_category_id)->first();
        $data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();
        $data['relatedBlogs']  = Blog::with(['details', 'category.details'])->where('id','!=',$id)->latest()->get();
        return view($this->theme . 'blogDetails', $data);
    }


    public function CategoryWiseBlog($slug = null, $id){

        $data['title'] = "Blog";

        $data['allBlogs'] = Blog::with(['details', 'category.details'])->where('blog_category_id', $id)->latest()->paginate(3);
        $data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();

        return view($this->theme . 'blog', $data);
    }


    public function blogSearch(Request $request){

        $data['title'] = "Blog";
        $search = $request->search;

        $data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();

        $data['allBlogs'] = Blog::with('details','category.details')
                            ->whereHas('category.details', function ($qq) use ($search){
                                $qq->where('name','Like', '%'.$search.'%');
                            })
                            ->orWhereHas('details', function ($qq2) use ($search){
                                $qq2->where('title','Like', '%'.$search.'%');
                                $qq2->orWhere('author','Like', '%'.$search.'%');
                                $qq2->orWhere('details','Like', '%'.$search.'%');
                            })
                            ->latest()->paginate(3);

        return view($this->theme . 'blog', $data);

    }


    public function faq()
    {
        $templateSection = ['faq'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['faq'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['increment'] = 1;
        return view($this->theme . 'faq', $data);
    }


    public function planList()
    {
        $templateSection = ['package'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $data['plans'] = Plan::with('details')->where('status', 1)->orderBy('price','asc')->get();

       if(Auth::user()){
            $data['freePlan'] = PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
       }

        $data['title'] = 'Packages';
        return view($this->theme . 'plan', $data);
    }


    public function story()
    {
        $templateSection = ['story'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $data['stories'] = Story::where('status',1)->latest()->paginate(config('basic.paginate'));

        return view($this->theme . 'story', $data);
    }


    public function storyDetails($slug = null, $id)
    {
        $data['story'] = Story::with('user')->where('id', $id)->firstOrFail();

        return view($this->theme . 'story-details', $data);
    }


    public function contact()
    {
        $templateSection = ['contact-us'];
        $templates = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');
        $title = 'Contact Us';
        $contact = @$templates['contact-us'][0];

        return view($this->theme . 'contact', compact('title', 'contact'));
    }


    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);
        $requestData = Purify::clean($request->except('_token', '_method'));

        $basic = (object)config('basic');
        $basicEmail = $basic->sender_email;

        $name = $requestData['name'];
        $email_from = $requestData['email'];
        $subject = $requestData['subject'];
        $message = $requestData['message']."<br>Regards<br>".$name;
        $from = $email_from;

        $headers = "From: <$from> \r\n";
        $headers .= "Reply-To: <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $to = $basicEmail;

        if (@mail($to, $subject, $message, $headers)) {
            // echo 'Your message has been sent.';
        } else {
            //echo 'There was a problem sending the email.';
        }

        return back()->with('success', 'Mail has been sent');
    }


    public function getLink($getLink = null, $id)
    {
        $getData = Content::findOrFail($id);

        $contentSection = [$getData->name];
        $contentDetail = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->where('content_id', $getData->id)
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $title = @$contentDetail[$getData->name][0]->description->title;
        $description = @$contentDetail[$getData->name][0]->description->description;
        return view($this->theme . 'getLink', compact('contentDetail', 'title', 'description'));
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:subscribers'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(url()->previous() . '#subscribe')->withErrors($validator);
        }
        $data = new Subscriber();
        $data->email = $request->email;
        $data->save();
        return redirect(url()->previous() . '#subscribe')->with('success', 'Subscribed Successfully');
    }

    public function language($code)
    {
        $language = Language::where('short_name', $code)->first();
        if (!$language) $code = 'US';
        session()->put('trans', $code);
        session()->put('rtl', $language ? $language->rtl : 0);
        return redirect()->back();
    }


    public function members()
    {
        $data['title'] = "Active Members";

        if (Auth::check()) {
            $user = Auth::user();
            $ignoreList = collect([]);
            Ignore::toBase()->where('user_id',$user->id)->select('member_id')->get()->map(function ($item) use ($ignoreList){
                $ignoreList->push($item->member_id);
            });
        }
        else{
            $ignoreList = collect([]);
        }

        $data['allUser'] = User::with('getReligion','getCaste','getPresentCountry','maritalStatus','profileInfo','purchasedPlanItems','shortlist','interest')
            ->whereHas('profileInfo', function ($query){
                return $query->where('status', 1);
            })
            ->whereNotIn('id',$ignoreList)
            ->orderBy('id','DESC')
            ->paginate(5);

        $data['maritalStatus'] = MaritalStatusDetails::latest()->get();
        $data['religion'] = Religion::latest()->get();
        $data['countries'] = Country::get(["name", "id"]);

        return view($this->theme . 'user.member.members', $data);
    }


    // Search Member
    public function searchMember(Request $request)
    {
        $this->validate($request, [
            'age_from' => 'nullable|integer',
            'age_to' => 'nullable|integer',
            'member_id' => 'nullable',
            'gender' => 'nullable',
            'marital_status ' => 'nullable',
            'religion' => 'nullable',
            'caste' => 'nullable',
            'mother_tongue' => 'nullable',
            'country' => 'nullable',
            'state' => 'nullable',
            'city' => 'nullable',
            'max_height' => 'nullable',
            'min_height' => 'nullable',
        ]);

        $search = $request->all();

        if (Auth::check()) {
            $user = Auth::user();
            $ignoreList = collect([]);
            Ignore::toBase()->where('user_id',$user->id)->select('member_id')->get()->map(function ($item) use ($ignoreList){
                $ignoreList->push($item->member_id);
            });
        }
        else{
            $ignoreList = collect([]);
        }

        $data['allUser'] = User::with('getReligion', 'getCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'maritalStatus', 'profileInfo', 'purchasedPlanItems', 'shortlist', 'interest')
            ->whereHas('profileInfo', function ($query) {
                return $query->where('status', 1);
            })
            ->whereNotIn('id', $ignoreList)
            ->when(isset($search['age_from']), function ($query) use ($search) {
                return $query->where('age', '>=', $search['age_from']);
            })
            ->when(isset($search['age_to']), function ($query) use ($search) {
                return $query->where('age', '<=', $search['age_to']);
            })
            ->when(isset($search['member_id']), function ($query) use ($search) {
                return $query->where('member_id', $search['member_id']);
            })
            ->when(isset($search['gender']), function ($query) use ($search) {
                return $query->where('gender', $search['gender']);
            })
            ->when(isset($search['marital_status']), function ($query) use ($search) {
                return $query->where('marital_status', $search['marital_status']);
            })
            ->when(isset($search['religion']), function ($query) use ($search) {
                return $query->where('religion', $search['religion']);
            })
            ->when(isset($search['caste']), function ($query) use ($search) {
                return $query->where('caste', $search['caste']);
            })
            ->when(isset($search['mother_tongue']), function ($query) use ($search) {
                return $query->where('mother_tongue', 'like', "%" . $search['mother_tongue'] . "%");
            })
            ->when(isset($search['country']), function ($query) use ($search) {
                return $query->where('present_country', $search['country'])
                    ->orWhere('permanent_country', $search['country']);
            })
            ->when(isset($search['state']), function ($query) use ($search) {
                return $query->where('present_state', $search['state'])
                    ->orWhere('permanent_state', $search['state']);
            })
            ->when(isset($search['city']), function ($query) use ($search) {
                return $query->where('present_city', $search['city'])
                    ->orWhere('permanent_city', $search['city']);
            })
            ->when(isset($search['max_height']), function ($query) use ($search) {
                return $query->where('height', '<=', $search['max_height']);
            })
            ->when(isset($search['min_height']), function ($query) use ($search) {
                return $query->where('height', '>=', $search['min_height']);
            })
            ->orderBy('id','DESC')
            ->paginate(5);

        $data['allUser']->appends($search);

        $data['maritalStatus'] = MaritalStatusDetails::latest()->get();
        $data['religion'] = Religion::latest()->get();
        $data['countries'] = Country::get(["name", "id"]);
        $data['title'] = "Active Members";

        return view($this->theme . 'user.member.members', $data);
    }





}
