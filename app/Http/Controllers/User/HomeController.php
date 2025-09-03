<?php

namespace App\Http\Controllers\User;

use session;
use Carbon\Carbon;
use App\Models\KYC;
use App\Models\City;
use App\Models\Fund;
use App\Models\Plan;
use App\Models\User;
use App\Models\Caste;
use App\Models\State;
use App\Models\Story;
use App\Models\Ignore;
use App\Models\Ticket;
use App\Models\Country;
use App\Models\Gateway;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Religion;
use App\Models\SubCaste;
use App\Models\HairColor;
use App\Models\Shortlist;
use App\Models\CareerInfo;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\ProfileInfo;
use App\Models\Transaction;
use App\Models\IdentifyForm;
use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Models\MaritalStatus;
use App\Models\BodyArtDetails;
use App\Models\BodyTypeDetails;
use App\Models\OnBehalfDetails;
use Illuminate\Validation\Rule;
use App\Models\EthnicityDetails;
use App\Models\HairColorDetails;
use App\Models\ComplexionDetails;

use App\Models\PurchasedPlanItem;
use App\Models\FamilyValueDetails;
use Illuminate\Support\Facades\DB;
use App\Helper\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\AffectionForDetails;
use App\Models\MaritalStatusDetails;
use App\Models\PersonalValueDetails;
use App\Models\PoliticalViewDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CommunityValueDetails;
use App\Models\HumorDetails;
use App\Models\ReligiousServiceDetails;
use Facades\App\Services\BasicService;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use hisorange\BrowserDetect\Parser as Browser;

class HomeController extends Controller
{
    use Upload, Notify;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['purchasedPlanItems'] = PurchasedPlanItem::where('user_id',$this->user->id)->first();
        $data['shortlistCount'] = Shortlist::where('user_id',$this->user->id)->count('member_id');
        $data['interestlistCount'] = Interest::where('user_id',$this->user->id)->count('member_id');
        $data['ignorelistCount'] = Ignore::where('user_id',$this->user->id)->count('member_id');
        $data['uploadedStoryCount'] = Story::where('user_id', auth()->user()->id)->where('status',1)->count();

        $monthlyPayments = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->funds()->whereNotNull('plan_id')->whereStatus(1)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyPayments) {
                $monthlyPayments->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['payment'] = $monthlyPayments;

        return view($this->theme . 'user.dashboard', $data, compact('monthly'));
    }


    public function purchasePlan(Request $request)
    {
        $this->validate($request, [
            'checkout' => 'required',
            'plan_id' => 'required',
        ]);

        $user = $this->user;

        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->first();
        if (!$plan) {
            return back()->with('error', 'Invalid Plan Request');
        }

        $balance_type = $request->checkout;
        if (!in_array($balance_type, ['checkout'])) {
            return back()->with('error', 'Invalid Wallet Type');
        }

        $amount = $plan->price;
        $basic = (object)config('basic');

        if ($amount == 0){
            $userId = $user->id;

            $userDataExist = PurchasedPlanItem::where('user_id',$userId)->first();

            if($userDataExist){
                $userDataExist->user_id = $userId;
                $userDataExist->show_auto_profile_match = DB::raw('show_auto_profile_match +'.$plan->show_auto_profile_match);
                $userDataExist->express_interest = DB::raw('express_interest +'.$plan->express_interest);
                $userDataExist->gallery_photo_upload = DB::raw('gallery_photo_upload +'.$plan->gallery_photo_upload);
                $userDataExist->contact_view_info = DB::raw('contact_view_info +'.$plan->contact_view_info);
                $userDataExist->free_plan_purchased = 1;
                $userDataExist->save();
            }
            else{
                $freePlan = new PurchasedPlanItem();
                $freePlan->user_id = $userId;
                $freePlan->show_auto_profile_match = $plan->show_auto_profile_match;
                $freePlan->express_interest = $plan->express_interest;
                $freePlan->gallery_photo_upload = $plan->gallery_photo_upload;
                $freePlan->contact_view_info = $plan->contact_view_info;
                $freePlan->free_plan_purchased = 1;
                $freePlan->save();
            }
            return redirect()->back()->with('success', 'Package Purchased Successfully');
        }
        else{
            if ($balance_type == "checkout") {
                session()->put('amount', encrypt($amount));
                session()->put('plan_id', encrypt($plan->id));
                return redirect()->route('user.add.purchase.plan');
            }
        }
    }


    public function addPurchasePlan()
    {
        $amount = session()->get('amount');
        $encPlanId = session()->get('plan_id');
        if ($encPlanId != null) {
            $plan = Plan::where('id', decrypt($encPlanId))->where('status', 1)->first();

            if (!$plan) {
                session()->forget('plan_id');
                session()->forget('amount');
            }
            $data['totalPayment'] = decrypt($amount);
        } else {
            $data['totalPayment'] = null;
            session()->forget('plan_id');
            session()->forget('amount');
        }

        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        return view($this->theme . 'user.addPurchasePlan', $data);
    }


    public function myPlans(){
        $myPlans = Fund::with('planDetails')->where('user_id', $this->user->id)->where('plan_id',"!=", null)->where('status', 1)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.myPlans.myPlans', compact('myPlans'));
    }


    public function purchasedPlanSearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $myPlans = Fund::with('planDetails.plan')->orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('plan_id',"!=", null)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->whereHas('planDetails', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['name']}%");
                });
            })
            ->when(isset($search['price']), function ($query) use ($search) {
                return $query->whereHas('planDetails.plan', function ($q) use ($search) {
                    $q->where('price', 'LIKE', "%{$search['price']}%");
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));

        $myPlans->appends($search);

        return view($this->theme . 'user.myPlans.myPlans', compact('myPlans'));
    }


    public function fundHistory()
    {
        $funds = Fund::where('user_id', $this->user->id)->where('status', '!=', 0)->where('plan_id',"!=", null)->orderBy('id', 'DESC')->with('gateway')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));
    }


    public function fundHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $funds = Fund::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('plan_id',"!=", null)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('transaction', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('gateway')
            ->paginate(config('basic.paginate'));
        $funds->appends($search);

        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));

    }


    public function addFund()
    {
        if (session()->get('plan_id') != null) {
            return redirect(route('user.payment'));
        }

        $data['totalPayment'] = null;
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view($this->theme . 'user.addFund', $data);
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['languages'] = Language::all();
        $data['identityFormList'] = IdentifyForm::where('status', 1)->get();
        if ($request->has('identity_type')) {
            $validator->errors()->add('identity', '1');
            $data['identity_type'] = $request->identity_type;
            $data['identityForm'] = IdentifyForm::where('slug', trim($request->identity_type))->where('status', 1)->firstOrFail();
            return view($this->theme . 'user.profile.myprofile', $data)->withErrors($validator);
        }

        $data['onBehalf'] = OnBehalfDetails::latest()->get();
        $data['maritalStatus'] = MaritalStatusDetails::latest()->get();
        $data['educationInfo'] = EducationInfo::where('user_id', auth()->user()->id)->get();
        $data['careerInfo'] = CareerInfo::where('user_id', auth()->user()->id)->get();
        $data['countries'] = Country::get(["name", "id"]);
        $data['familyValues'] = FamilyValueDetails::latest()->get();
        $data['religion'] = Religion::latest()->get();
        $data['hairColor'] = HairColorDetails::latest()->get();
        $data['bodyType'] = BodyTypeDetails::latest()->get();
        $data['complexion'] = ComplexionDetails::latest()->get();
        $data['bodyArt'] = BodyArtDetails::latest()->get();
        $data['ethnicity'] = EthnicityDetails::latest()->get();
        $data['personalValue'] = PersonalValueDetails::latest()->get();
        $data['communityValue'] = CommunityValueDetails::latest()->get();
        $data['politicalView'] = PoliticalViewDetails::latest()->get();
        $data['religiousService'] = ReligiousServiceDetails::latest()->get();
        $data['affectionFor'] = AffectionForDetails::latest()->get();
        $data['humor'] = HumorDetails::latest()->get();


        $sss = ProfileInfo::firstOrNew(['user_id'=>auth()->id()]);
        $getStep = collect($sss)->except(['id','user_id','created_at','updated_at','status','astronomic_info']);
        $totalStep = count($getStep);
        $filtered = $getStep->values()->filter(function ($value, $key){
            return $value > 0;
        });
        $complete = count($filtered->all());
        $profileComplete = $totalStep == 0 ? 0 : round(($complete*100/$totalStep), 2);
        $data['profileComplete'] = $profileComplete;

        $data['approvedProfile'] = ProfileInfo::select('status')->where('user_id', auth()->id())->first();

        return view($this->theme . 'user.profile.myprofile', $data);
    }


    public function updateIntroduction(Request $request){

        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = Purify::clean($request->all());

        $user = $this->user;

        $rules = [
            'introduction' => 'sometimes|required|max:1000',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'introduction.required' => 'Introduction field is required',
            'introduction.max' => 'This field may not be greater than :max characters.'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('intro', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->introduction = $req['introduction'];
        $user->save();

        $intro =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $intro->intro = 1;
        $intro->save();

        session()->put('name','intro');

        return back()->with('success', 'Introduction Updated Successfully.');
    }


    public function updateInformation(Request $request)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $user = $this->user;

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
            'gender' => 'required',
            'date_of_birth' => 'required',
            'on_behalf' => 'required|integer',
            'marital_status' => 'required|integer',
            'no_of_children' => 'required|integer',
            'image' => 'sometimes|max:3072|mimes:jpg,jpeg,png',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name field is required',
            'lastname.required' => 'Last Name field is required',
            'gender.required' => 'Gender field is required',
            'date_of_birth.required' => 'Date of Birth field is required',
            'on_behalf.required' => 'On Behalf field is required',
            'marital_status.required' => 'Marital Status field is required',
            'no_of_children.required' => 'No of Children field is required',
            'image.required' => 'Image field is required',
            'image.mimes' => 'This image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'This image may not be greater than :max kilobytes.',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('basicInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->firstname = $req['firstname'];
        $user->lastname = $req['lastname'];
        $user->username = $req['username'];
        $user->gender = $req['gender'];
        $user->date_of_birth = $req['date_of_birth'];
        $user->age = date_diff(date_create($req['date_of_birth']), date_create('today'))->y;
        $user->on_behalf = $req['on_behalf'];
        $user->marital_status = $req['marital_status'];
        $user->no_of_children = $req['no_of_children'];
        $user->language_id = $req['language_id'];

        $old_image = $user->image;

        if ($request->hasFile('image')) {
            try {
                $user->image = $this->uploadImage($request->image, config('location.user.path'), config('location.user.size'), $old_image);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $user->save();

        $basic_info =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $basic_info->basic_info = 1;
        $basic_info->save();

        session()->put('name','basicInfo');

        return back()->with('success', 'Basic Information Updated Successfully.');
    }


    public function physicalAttributes(Request $request)
    {
        $bloodGroupList = collect(config('bloodgroup'))->keys();

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'hairColor' => 'required',
            'complexion' => 'required',
            'bloodGroup' => Rule::in($bloodGroupList),
            'body_type' => 'required',
            'disability' => 'required'
        ];
        $message = [
            'height.required' => 'Height field is required',
            'weight.required' => 'Weight field is required',
            'hairColor.required' => 'Hair Color field is required',
            'complexion.required' => 'Complexion field is required',
            'body_type.required' => 'Body Type field is required',
            'disability.required' => 'Disability field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('physicalAttributes', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->height = $req['height'];
        $user->weight = $req['weight'];
        $user->eyeColor = $req['eyeColor'];
        $user->hairColor = $req['hairColor'];
        $user->complexion = $req['complexion'];
        $user->bloodGroup = $req['bloodGroup'];
        $user->body_type = $req['body_type'];
        $user->body_art = $req['body_art'];
        $user->disability = $req['disability'];

        $user->save();

        $physical_attributes =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $physical_attributes->physical_attributes = 1;
        $physical_attributes->save();

        session()->put('name','physicalAttributes');

        return back()->with('success', 'Physical Attributes Updated Successfully.');
    }


    public function setLanguage(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'mother_tongue' => 'required',
            'known_languages' => 'required'
        ];
        $message = [
            'mother_tongue.required' => 'Mother Tongue field is required',
            'known_languages.required' => 'Known Language field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('language', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->mother_tongue = $req['mother_tongue'];
        $user->known_languages = $req['known_languages'] ?? [];
        $user->save();

        $language =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $language->language = 1;
        $language->save();


        session()->put('name','setlanguages');

        return back()->with('success', 'Language Updated Successfully.');
    }


    public function presentAddress(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'present_country' => 'required',
            'present_state' => 'required',
            'present_city' => 'required',
            'present_postcode' => 'required',
            'present_address' => 'required'
        ];
        $message = [
            'present_country.required' => 'Country field is required',
            'present_state.required' => 'State field is required',
            'present_city.required' => 'City field is required',
            'present_postcode.required' => 'Postal Code field is required',
            'present_address.required' => 'Address field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('presentAddress', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->present_country = $req['present_country'];
        $user->present_state = $req['present_state'];
        $user->present_city = $req['present_city'];
        $user->present_postcode = $req['present_postcode'];
        $user->present_address = $req['present_address'];
        $user->save();

        $present_address =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $present_address->present_address = 1;
        $present_address->save();

        session()->put('name','presentAddress');

        return back()->with('success', 'Present Address Updated Successfully.');
    }


    public function permanentAddress(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'permanent_country' => 'required',
            'permanent_state' => 'required',
            'permanent_city' => 'required',
            'permanent_postcode' => 'required',
            'permanent_address' => 'required'
        ];
        $message = [
            'permanent_country.required' => 'Country field is required',
            'permanent_state.required' => 'State field is required',
            'permanent_city.required' => 'City field is required',
            'permanent_postcode.required' => 'Postal Code field is required',
            'permanent_address.required' => 'Address field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('permanentAddress', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->permanent_country = $req['permanent_country'];
        $user->permanent_state = $req['permanent_state'];
        $user->permanent_city = $req['permanent_city'];
        $user->permanent_postcode = $req['permanent_postcode'];
        $user->permanent_address = $req['permanent_address'];
        $user->save();

        $permanent_address =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $permanent_address->permanent_address = 1;
        $permanent_address->save();

        session()->put('name','permanentAddress');

        return back()->with('success', 'Permanent Address Updated Successfully.');
    }


    public function hobbyInterest(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'hobbies' => 'required',
            'interests' => 'required',
            'dress_styles' => 'required',
        ];
        $message = [
            'hobbies.required' => 'Country field is required',
            'interests.required' => 'Interests field is required',
            'dress_styles.required' => 'Dress Styles field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('hobbyInterest', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->hobbies = $req['hobbies'];
        $user->interests = $req['interests'];
        $user->music = $req['music'];
        $user->books = $req['books'];
        $user->movies = $req['movies'];
        $user->tv_shows = $req['tv_shows'];
        $user->sports = $req['sports'];
        $user->fitness_activities = $req['fitness_activities'];
        $user->cuisines = $req['cuisines'];
        $user->dress_styles = $req['dress_styles'];

        $user->save();

        $hobbies_interest =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $hobbies_interest->hobbies_interest = 1;
        $hobbies_interest->save();

        session()->put('name','hobbyInterest');

        return back()->with('success', 'Hobbies & Interest Updated Successfully.');
    }


    public function personalAttitudeBehavior(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'affection' => 'required',
            'political_views' => 'required',
            'religious_service' => 'required',
        ];
        $message = [
            'affection.required' => 'Affection field is required',
            'political_views.required' => 'Political Views field is required',
            'religious_service.required' => 'Religious Service field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('personalAttitudeBehavior', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->affection_id = $req['affection'];
        $user->humor_id = $req['humor'];
        $user->political_views = $req['political_views'];
        $user->religious_service = $req['religious_service'];

        $user->save();

        $attitude_behavior =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $attitude_behavior->attitude_behavior = 1;
        $attitude_behavior->save();

        session()->put('name','personalAttitudeBehavior');

        return back()->with('success', 'Personal Attitude & Behavior Updated Successfully.');
    }


    public function residencyInformation(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'birth_country' => 'required',
            'growup_country' => 'required',
        ];
        $message = [
            'birth_country.required' => 'Birth Country field is required',
            'growup_country.required' => 'Growup Country field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('residencyInformation', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->birth_country = $req['birth_country'];
        $user->residency_country = $req['residency_country'];
        $user->growup_country = $req['growup_country'];
        $user->immigration_status = $req['immigration_status'];

        $user->save();

        $residency_information =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $residency_information->residency_information = 1;
        $residency_information->save();

        session()->put('name','residencyInformation');

        return back()->with('success', 'Residency Information Updated Successfully.');
    }


    public function spiritualSocialBg(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'religion' => 'required',
            'caste' => 'required',
            'family_value' => 'required',
            'community_value' => 'required',
        ];
        $message = [
            'religion.required' => 'Religion field is required',
            'caste.required' => 'Caste field is required',
            'family_value.required' => 'Family Value field is required',
            'community_value.required' => 'Community Value field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('spiritualSocialBg', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->religion = $req['religion'];
        $user->caste = $req['caste'];
        $user->sub_caste = $req['sub_caste'];
        $user->ethnicity = $req['ethnicity'];
        $user->personal_value = $req['personal_value'];
        $user->family_value = $req['family_value'];
        $user->community_value = $req['community_value'];

        $user->save();

        $spiritual_social_bg =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $spiritual_social_bg->spiritual_social_bg = 1;
        $spiritual_social_bg->save();

        session()->put('name','spiritualSocialBg');

        return back()->with('success', 'Spiritual & Social Background Updated Successfully.');
    }


    public function lifestyle(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'diet' => 'required',
            'drink' => 'required',
            'smoke' => 'required',
            'living_with' => 'required',
        ];
        $message = [
            'diet.required' => 'Diet field is required',
            'drink.required' => 'Drink field is required',
            'smoke.required' => 'Smoke field is required',
            'living_with.required' => 'Living With field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('lifestyle', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->diet = $req['diet'];
        $user->drink = $req['drink'];
        $user->smoke = $req['smoke'];
        $user->living_with = $req['living_with'];

        $user->save();

        $lifestyle =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $lifestyle->lifestyle = 1;
        $lifestyle->save();

        session()->put('name','lifestyle');

        return back()->with('success', 'Lifestyle Updated Successfully.');
    }


    public function astronomicInformation(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'sun_sign' => 'sometimes',
            'moon_sign' => 'sometimes',
            'time_of_birth' => 'sometimes',
            'city_of_birth' => 'sometimes',
        ];
        $message = [

        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('astronomicInformation', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->sun_sign = $req['sun_sign'];
        $user->moon_sign = $req['moon_sign'];
        $user->time_of_birth = $req['time_of_birth'];
        $user->city_of_birth = $req['city_of_birth'];

        $user->save();

        $astronomic_info =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $astronomic_info->astronomic_info = 1;
        $astronomic_info->save();

        session()->put('name','astronomicInformation');

        return back()->with('success', 'Astronomic Information Updated Successfully.');
    }


    public function familyInformation(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'father' => 'required',
            'mother' => 'required',
            'brother_no' => 'required',
            'sister_no' => 'required',
            'sibling_position' => 'required',
        ];
        $message = [
            'father.required' => 'Father field is required',
            'mother.required' => 'Mother field is required',
            'brother_no.required' => 'No. Of Brothers field is required',
            'sister_no.required' => 'No. Of Sisters field is required',
            'sibling_position.required' => 'Sibling Position field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('familyInformation', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->father = $req['father'];
        $user->mother = $req['mother'];
        $user->brother_no = $req['brother_no'];
        $user->sister_no = $req['sister_no'];
        $user->sibling_position = $req['sibling_position'];

        $user->save();

        $family_information =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $family_information->family_information = 1;
        $family_information->save();

        session()->put('name','familyInformation');

        return back()->with('success', 'Family Information Updated Successfully.');
    }


    public function partnerExpectation(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));

        $user = $this->user;

        $rules = [
            'partner_general_requirement' => 'required',
            'partner_residence_country' => 'required',
            'partner_min_height' => 'required',
            'partner_max_weight' => 'required',
            'partner_gender' => 'required',
            'partner_marital_status' => 'required',
            'partner_children_acceptancy' => 'required',
            'partner_religion' => 'required',
            'partner_caste' => 'required',
            'partner_language' => 'required',
            'partner_education' => 'required',
            'partner_profession' => 'nullable',
            'partner_smoking_acceptancy' => 'required',
            'partner_drinking_acceptancy' => 'required',
            'partner_dieting_acceptancy' => 'required',
            'partner_body_type' => 'required',
            'partner_personal_value' => 'required',
            'partner_manglik' => 'sometimes',
            'partner_preferred_country' => 'required',
            'partner_preferred_state' => 'nullable',
            'partner_preferred_city' => 'nullable',
            'partner_family_value' => 'required',
            'partner_complexion' => 'required',
        ];
        $message = [
            'partner_general_requirement.required' => 'General Requirement field is required',
            'partner_residence_country.required' => 'Residence Country field is required',
            'partner_min_height.required' => 'Min Height field is required',
            'partner_max_weight.required' => 'Max Weight field is required',
            'partner_gender.required' => 'Gender field is required',
            'partner_marital_status.required' => 'Marital Status field is required',
            'partner_children_acceptancy.required' => 'Children Acceptancy field is required',
            'partner_religion.required' => 'Religion field is required',
            'partner_caste.required' => 'Caste field is required',
            'partner_language.required' => 'Language field is required',
            'partner_education.required' => 'Education field is required',
            // 'partner_profession.required' => 'Profession field is required',
            'partner_smoking_acceptancy.required' => 'Smoking Acceptancy field is required',
            'partner_drinking_acceptancy.required' => 'Drinking Acceptancy field is required',
            'partner_dieting_acceptancy.required' => 'Dieting Acceptancy field is required',
            'partner_body_type.required' => 'Body Type field is required',
            'partner_personal_value.required' => 'Personal Value field is required',
            'partner_preferred_country.required' => 'Country field is required',
//            'partner_preferred_state.required' => 'State field is required',
//            'partner_preferred_city.required' => 'City field is required',
            'partner_family_value.required' => 'Family Value field is required',
            'partner_complexion.required' => 'Complexion field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('partnerExpectation', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $user->partner_general_requirement = $req['partner_general_requirement'];
        $user->partner_residence_country = $req['partner_residence_country'];
        $user->partner_min_height = $req['partner_min_height'];
        $user->partner_max_weight = $req['partner_max_weight'];
        $user->partner_gender = $req['partner_gender'];
        $user->partner_marital_status = $req['partner_marital_status'];
        $user->partner_children_acceptancy = $req['partner_children_acceptancy'];
        $user->partner_religion = $req['partner_religion'];
        $user->partner_caste = $req['partner_caste'];
        $user->partner_sub_caste = $req['partner_sub_caste'];
        $user->partner_language = $req['partner_language'];
        $user->partner_education = $req['partner_education'];
        $user->partner_profession = $req['partner_profession'];
        $user->partner_smoking_acceptancy = $req['partner_smoking_acceptancy'];
        $user->partner_drinking_acceptancy = $req['partner_drinking_acceptancy'];
        $user->partner_dieting_acceptancy = $req['partner_dieting_acceptancy'];
        $user->partner_body_type = $req['partner_body_type'];
        $user->partner_personal_value = $req['partner_personal_value'];
        $user->partner_manglik = $req['partner_manglik'];
        $user->partner_preferred_country = $req['partner_preferred_country'];
        $user->partner_preferred_state = $req['partner_preferred_state'];
        $user->partner_preferred_city = $req['partner_preferred_city'];
        $user->partner_family_value = $req['partner_family_value'];
        $user->partner_complexion = $req['partner_complexion'];

        $user->save();

        $partner_expectation =  ProfileInfo::firstOrNew([
            'user_id' =>$user->id
        ]);
        $partner_expectation->partner_expectation = 1;
        $partner_expectation->save();

        session()->put('name','partnerExpectation');

        return back()->with('success', 'Partner Expectation Updated Successfully.');
    }


    public function getCaste(Request $request)
    {
        $data['caste'] = Caste::where("religion_id",$request->religion_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getSubCaste(Request $request)
    {
        $data['subCaste'] = SubCaste::where("caste_id",$request->caste_id)->get(["name", "id"]);
        return response()->json($data);
    }


    // change password
    public function changePassword()
    {
        $user = $this->user;
        $languages = Language::all();
        return view($this->theme . 'user.profile.changePassword', compact('user', 'languages'));
    }


    // update password
    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Changed Successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // two factor
    public function twoStepSecurity()
    {
        $basic = (object)config('basic');
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $secret);
        $previousCode = $this->user->two_fa_code;

        $previousQR = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $previousCode);
        return view($this->theme . 'user.twoFA.index', compact('secret', 'qrCodeUrl', 'previousCode', 'previousQR'));
    }


    public function twoStepEnable(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = $request->key;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);
            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }


    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = $this->user;
        $ga = new GoogleAuthenticator();

        $secret = $user->two_fa_code;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['two_fa'] = 0;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = null;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_DISABLED', [
                'action' => 'Disabled',
                'ip' => request()->ip(),
                'browser' => $browser->browserName() . ', ' . $browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Disabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }



    public function verificationSubmit(Request $request)
    {
        $identityFormList = IdentifyForm::where('status', 1)->get();
        $rules['identity_type'] = ["required", Rule::in($identityFormList->pluck('slug')->toArray())];
        $identity_type = $request->identity_type;
        $identityForm = IdentifyForm::where('slug', trim($identity_type))->where('status', 1)->firstOrFail();

        $params = $identityForm->services_form;

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('identity', '1');

            return back()->withErrors($validator)->withInput();
        }


        $path = config('location.kyc.path') . date('Y') . '/' . date('m') . '/' . date('d');
        $collection = collect($request);

        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $this->uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    session()->flash('error', 'Could not upload your ' . $inKey);
                                    return back()->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
        }

        try {

            DB::beginTransaction();

            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = $identityForm->slug;
            $kyc->details = $reqField;
            $kyc->save();

            $user->identity_verify = 1;
            $user->save();

            if (!$kyc) {
                DB::rollBack();
                $validator->errors()->add('identity', '1');
                return back()->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'KYC request has been submitted.');

        } catch (\Exception $e) {
            return redirect()->route('user.profile')->withErrors($validator)->with('error', $e->getMessage());
        }
    }

    public function addressVerification(Request $request)
    {

        $rules = [];
        $rules['addressProof'] = ['image', 'mimes:jpeg,jpg,png', 'max:2048'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('addressVerification', '1');
            return back()->withErrors($validator)->withInput();
        }

        $path = config('location.kyc.path') . date('Y') . '/' . date('m') . '/' . date('d');

        $reqField = [];
        try {
            if ($request->hasFile('addressProof')) {
                $reqField['addressProof'] = [
                    'field_name' => $this->uploadImage($request['addressProof'], $path),
                    'type' => 'file',
                ];
            } else {
                $validator->errors()->add('addressVerification', '1');

                session()->flash('error', 'Please select a ' . 'address Proof');
                return back()->withInput();
            }
        } catch (\Exception $exp) {
            session()->flash('error', 'Could not upload your ' . 'address Proof');
            return redirect()->route('user.profile')->withInput();
        }

        try {

            DB::beginTransaction();
            $user = $this->user;
            $kyc = new KYC();
            $kyc->user_id = $user->id;
            $kyc->kyc_type = 'address-verification';
            $kyc->details = $reqField;
            $kyc->save();
            $user->address_verify = 1;
            $user->save();

            if (!$kyc) {
                DB::rollBack();
                $validator->errors()->add('addressVerification', '1');
                return redirect()->route('user.profile')->withErrors($validator)->withInput()->with('error', "Failed to submit request");
            }
            DB::commit();
            return redirect()->route('user.profile')->withErrors($validator)->with('success', 'Your request has been submitted.');

        } catch (\Exception $e) {
            $validator->errors()->add('addressVerification', '1');
            return redirect()->route('user.profile')->with('error', $e->getMessage())->withErrors($validator);
        }
    }


}
