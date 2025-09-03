<?php

namespace App\Models;

use App\Http\Traits\Notify;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules\In;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Notify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $allusers = [];

    protected $appends = ['fullname', 'mobile', 'affection', 'humor'];

    protected $dates = ['sent_at'];

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getMobileAttribute()
    {
        return $this->phone_code . $this->phone;
    }

    public function funds()
    {
        return $this->hasMany(Fund::class)->latest()->where('status', '!=', 0);
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->latest();
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }


    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    public function siteNotificational()
    {
        return $this->morphOne(SiteNotification::class, 'siteNotificational', 'site_notificational_type', 'site_notificational_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ]);
    }


    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->username]);
    }

    public function scopeLevel()
    {
        $count = 0;
        $user_id = $this->id;
        while ($user_id != null) {
            $user = User::where('referral_id', $user_id)->first();
            if (!$user) {
                break;
            } else {
                $user_id = $user->id;
                $count++;
            }
        }
        return $count;
    }

    public function referralUsers($id, $currentLevel = 1)
    {
        $users = $this->getUsers($id);
        if ($users['status']) {
            $this->allusers[$currentLevel] = $users['user'];
            $currentLevel++;
            $this->referralUsers($users['ids'], $currentLevel);
        }
        return $this->allusers;
    }

    public function getUsers($id)
    {
        if (isset($id)) {
            $data['user'] = User::whereIn('referral_id', $id)->get(['id', 'firstname', 'lastname', 'username', 'email', 'phone_code', 'phone', 'referral_id', 'created_at']);
            if (count($data['user']) > 0) {
                $data['status'] = true;
                $data['ids'] = $data['user']->pluck('id');
                return $data;
            }
        }
        $data['status'] = false;
        return $data;
    }


    public function educationInfo()
    {
        return $this->hasMany(EducationInfo::class, 'user_id', 'id');
    }

    public function careerInfo()
    {
        return $this->hasMany(CareerInfo::class, 'user_id', 'id');
    }

    public function userPost()
    {
        return $this->hasOne(UserPost::class, 'user_id', 'id');
    }

    public function getReligion()
    {
        return $this->belongsTo(Religion::class, 'religion', 'id');
    }

    public function getCaste()
    {
        return $this->belongsTo(Caste::class, 'caste', 'id');
    }

    public function getSubCaste()
    {
        return $this->belongsTo(SubCaste::class, 'sub_caste', 'id');
    }

    public function getPresentCountry()
    {
        return $this->belongsTo(Country::class, 'present_country', 'id');
    }

    public function getPresentState()
    {
        return $this->belongsTo(State::class, 'present_state', 'id');
    }

    public function getPresentCity()
    {
        return $this->belongsTo(City::class, 'present_city', 'id');
    }

    public function getPermanentCountry()
    {
        return $this->belongsTo(Country::class, 'permanent_country', 'id');
    }

    public function getPermanentState()
    {
        return $this->belongsTo(State::class, 'permanent_state', 'id');
    }

    public function getPermanentCity()
    {
        return $this->belongsTo(City::class, 'permanent_city', 'id');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatusDetails::class, 'marital_status', 'marital_status_id');
    }

    public function onBehalf()
    {
        return $this->belongsTo(OnBehalfDetails::class, 'on_behalf', 'on_behalf_id');
    }

    public function getBirthCountry()
    {
        return $this->belongsTo(Country::class, 'birth_country', 'id');
    }

    public function getResidencyCountry()
    {
        return $this->belongsTo(Country::class, 'residency_country', 'id');
    }

    public function getGrowupCountry()
    {
        return $this->belongsTo(Country::class, 'growup_country', 'id');
    }

    public function getFamilyValue()
    {
        return $this->belongsTo(FamilyValueDetails::class, 'family_value', 'family_values_id');
    }

    public function partnerResidenceCountry()
    {
        return $this->belongsTo(Country::class, 'partner_residence_country', 'id');
    }

    public function partnerMaritalStatus()
    {
        return $this->belongsTo(MaritalStatusDetails::class, 'partner_marital_status', 'marital_status_id');
    }

    public function partnerReligion()
    {
        return $this->belongsTo(Religion::class, 'partner_religion', 'id');
    }

    public function partnerCaste()
    {
        return $this->belongsTo(Caste::class, 'partner_caste', 'id');
    }

    public function partnerSubCaste()
    {
        return $this->belongsTo(SubCaste::class, 'partner_sub_caste', 'id');
    }

    public function partnerPreferredCountry()
    {
        return $this->belongsTo(Country::class, 'partner_preferred_country', 'id');
    }

    public function partnerPreferredState()
    {
        return $this->belongsTo(State::class, 'partner_preferred_state', 'id');
    }

    public function partnerPreferredtCity()
    {
        return $this->belongsTo(City::class, 'partner_preferred_city', 'id');
    }

    public function partnerFamilyValue()
    {
        return $this->belongsTo(FamilyValueDetails::class, 'partner_family_value', 'family_values_id');
    }

    public function profileInfo()
    {
        return $this->hasOne(ProfileInfo::class, 'user_id', 'id');
    }

    public function purchasedPlanItems()
    {
        return $this->hasOne(PurchasedPlanItem::class, 'user_id', 'id');
    }

    public function shortlist()
    {
        return $this->hasOne(Shortlist::class, 'member_id', 'id')->where('user_id', auth()->id());
    }

    public function profileView()
    {
        return $this->hasOne(ProfileView::class, 'member_id', 'id')->where('user_id', auth()->id());
    }

    public function interest()
    {
        return $this->hasOne(Interest::class, 'member_id', 'id')->where('user_id', auth()->id());
    }

    public function myIgnoreList()
    {
        return $this->hasMany(Ignore::class, 'user_id');
    }

    public function report()
    {
        return $this->hasMany(Ignore::class, 'member_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'user_id', 'id');
    }

    public function bodyType()
    {
        return $this->belongsTo(BodyTypeDetails::class, 'body_type', 'body_types_id');
    }

    public function bodyArt()
    {
        return $this->belongsTo(BodyArtDetails::class, 'body_art', 'body_art_id');
    }

    public function userComplexion()
    {
        return $this->belongsTo(ComplexionDetails::class, 'complexion', 'complexion_id');
    }

    public function userHairColor()
    {
        return $this->belongsTo(HairColorDetails::class, 'hairColor', 'hair_color_id');
    }

    public function userEthnicity()
    {
        return $this->belongsTo(EthnicityDetails::class, 'ethnicity', 'ethnicity_id');
    }

    public function personalValue()
    {
        return $this->belongsTo(PersonalValueDetails::class, 'personal_value', 'personal_value_id');
    }

    public function communityValue()
    {
        return $this->belongsTo(CommunityValueDetails::class, 'community_value', 'community_value_id');
    }

    public function politicalView()
    {
        return $this->belongsTo(PoliticalViewDetails::class, 'political_views', 'political_view_id');
    }

    public function religiousService()
    {
        return $this->belongsTo(ReligiousServiceDetails::class, 'religious_service', 'religious_service_id');
    }

    public function affectionFor()
    {
        return $this->belongsTo(AffectionForDetails::class, 'affection', 'affection_for_id');
    }

    public function userHumor()
    {
        return $this->belongsTo(HumorDetails::class, 'humor', 'humor_id');
    }

    public function getAffectionAttribute()
    {
        $affection = array();

        if ($this->affection_id != null) {
            foreach (json_decode($this->affection_id) as $item)
            {
                $affection[] =  $item;
            }
        }

        $res =  AffectionFor::whereIn('id', $affection)->with('details')->get()->map(function ($item){
            return optional($item->details)->name??'';
        });

        return $res->toArray();
    }

    public function getHumorAttribute()
    {
        $humor = array();
        if ($this->humor_id) {
            foreach (json_decode($this->humor_id) as $item)
            {
                $humor[] =  $item;
            }
        }

        $res =  Humor::whereIn('id', $humor)->with('details')->get()->map(function ($item){
            return optional($item->details)->name??'';
        });

        return $res->toArray();
    }

}
