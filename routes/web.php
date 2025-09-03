<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');


Route::get('/user', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/loginModal', 'Auth\LoginController@loginModal')->name('loginModal');

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['guest']], function () {
    Route::get('register/{sponsor?}', 'Auth\RegisterController@sponsor')->name('register.sponsor');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/check', 'User\VerificationController@check')->name('check');
    Route::get('/resend_code', 'User\VerificationController@resendCode')->name('resendCode');
    Route::post('/mail-verify', 'User\VerificationController@mailVerify')->name('mailVerify');
    Route::post('/sms-verify', 'User\VerificationController@smsVerify')->name('smsVerify');
    Route::post('twoFA-Verify', 'User\VerificationController@twoFAverify')->name('twoFA-Verify');
    Route::middleware('userCheck')->group(function () {
        Route::get('/dashboard', 'User\HomeController@index')->name('home');

        // User Message
        Route::get('/messenger', 'User\MessengerController@messenger')->name('messenger');
        Route::post('send/message/{id}', 'User\MessengerController@sendNewMessage')->name('send.message');

        // Messenger
        Route::get('chat/contacts', 'User\MessengerController@getContacts')->name('chat.contact');
        Route::get('single/member/messages/{id}', 'User\MessengerController@getMessages');
        Route::post('chat/send-message', 'User\MessengerController@sendMessage')->name('chat.send-message');
        Route::put('chat/leaving/time/{id}', 'User\MessengerController@chatLeaveingTime');
        Route::post('delete/pushnotification/{id}', 'User\MessengerController@deletePushnotification');


        // Story
        Route::get('/story', 'User\StoryController@storyList')->name('story');
        Route::get('/story/create', 'User\StoryController@storyCreate')->name('story.create');
        Route::post('/story/store', 'User\StoryController@storyStore')->name('story.store');

        Route::delete('/story-delete/{id}', 'User\StoryController@storyDelete')->name('story.delete');
        Route::get('/story-edit/{id}', 'User\StoryController@storyEdit')->name('story.edit');
        Route::delete('/gallery-image-delete/{id}/{imgDelete}', 'User\StoryController@galleryImageDelete')->name('galleryImageDelete');
        Route::put('/story-update/{id}', 'User\StoryController@storyUpdate')->name('story.update');

        // Gallery
        Route::get('/gallery', 'User\GalleryController@galleryList')->name('gallery');
        Route::get('/gallery/create', 'User\GalleryController@galleryCreate')->name('gallery.create');
        Route::post('/gallery/store', 'User\GalleryController@galleryStore')->name('gallery.store');
        Route::delete('/gallery/delete/{id}', 'User\GalleryController@galleryDelete')->name('gallery.delete');

        // plan purchase
        Route::post('/purchase-plan', 'User\HomeController@purchasePlan')->name('purchase-plan');
        Route::get('add/purchase/plan', 'User\HomeController@addPurchasePlan')->name('add.purchase.plan');

        Route::post('purchase/plan/request', 'PaymentController@purchasePlanRequest')->name('purchase.plan.request');
        Route::get('purchase/plan/confirm', 'PaymentController@purchasePlanConfirm')->name('purchase.plan.request.confirm');
        Route::post('purchase/plan/confirm', 'PaymentController@fromSubmit')->name('purchase.plan.request.fromSubmit');

        // My Plan
        Route::get('my-plans', 'User\HomeController@myPlans')->name('myPlans');
        Route::get('purchased/plan/search', 'User\HomeController@purchasedPlanSearch')->name('purchased.plan.search');

        // Shortlist
        Route::get('shortlist/show', 'User\ShortlistController@shortListShow')->name('shortlist.show');
        Route::delete('shortlist/delete/{id}', 'User\ShortlistController@shortListDelete')->name('shortlist.delete');
        Route::get('shortlist/search', 'User\ShortlistController@shortListSearch')->name('shortlist.search');

        // Interest
        Route::get('interest/show', 'User\InterestController@interestListShow')->name('interest.show');
        Route::delete('interest/delete/{id}', 'User\InterestController@interestListDelete')->name('interest.delete');
        Route::get('interest/search', 'User\InterestController@interestListSearch')->name('interest.search');

        // Member's profile show
        Route::get('/member/profile/{id}', 'User\ProfileViewController@memberProfileShow')->name('member.profile.show');

        // Ignore Member
        Route::get('ignore/members/show', 'User\IgnoreController@ignoreListShow')->name('ignore.show');
        Route::delete('ignore/delete/{id}', 'User\IgnoreController@ignoreListDelete')->name('ignore.delete');
        Route::get('ignore/search', 'User\IgnoreController@ignoreListSearch')->name('ignore.search');

        // Ignore Member
        Route::get('matched/profile', 'User\ProfileViewController@matchedProfile')->name('matched.profile');

        // Report Member
        Route::post('report/member/{id}', 'User\ReportController@reportSubmit')->name('report.submit');


        // add fund
        Route::get('add-fund', 'User\HomeController@addFund')->name('addFund');
        Route::post('add-fund', 'PaymentController@addFundRequest')->name('addFund.request');
        Route::get('addFundConfirm', 'PaymentController@depositConfirm')->name('addFund.confirm');
        Route::post('addFundConfirm', 'PaymentController@fromSubmit')->name('addFund.fromSubmit');


        //user payment history
        Route::get('fund-history', 'User\HomeController@fundHistory')->name('fund-history');
        Route::get('fund-history-search', 'User\HomeController@fundHistorySearch')->name('fund-history.search');


        // TWO-FACTOR SECURITY
        Route::get('/twostep-security', 'User\HomeController@twoStepSecurity')->name('twostep.security');
        Route::post('twoStep-enable', 'User\HomeController@twoStepEnable')->name('twoStepEnable');
        Route::post('twoStep-disable', 'User\HomeController@twoStepDisable')->name('twoStepDisable');


        Route::get('push-notification-show', 'SiteNotificationController@show')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAll')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');


        // User Change Password
        Route::get('/change/password', 'User\HomeController@changePassword')->name('change.password');
        Route::post('/updatePassword', 'User\HomeController@updatePassword')->name('updatePassword');


        // User Profile
        Route::get('/profile', 'User\HomeController@profile')->name('profile');
        Route::post('/update/introduction', 'User\HomeController@updateIntroduction')->name('update.introduction');
        Route::put('/update/information', 'User\HomeController@updateInformation')->name('updateInformation');
        Route::post('/present/address', 'User\HomeController@presentAddress')->name('presentAddress');
        Route::post('/permanent/address', 'User\HomeController@permanentAddress')->name('permanentAddress');
        Route::post('/physical/attributes', 'User\HomeController@physicalAttributes')->name('physicalAttributes');
        Route::post('/attitude/behavior', 'User\HomeController@personalAttitudeBehavior')->name('personalAttitudeBehavior');
        Route::post('/residency/information', 'User\HomeController@residencyInformation')->name('residencyInformation');
        Route::post('/setLanguage', 'User\HomeController@setLanguage')->name('setLanguage');
        Route::post('/hobby/interest', 'User\HomeController@hobbyInterest')->name('hobbyInterest');
        Route::post('/lifestyle', 'User\HomeController@lifestyle')->name('lifestyle');
        Route::post('/astronomic/information', 'User\HomeController@astronomicInformation')->name('astronomicInformation');
        Route::post('/family/information', 'User\HomeController@familyInformation')->name('familyInformation');
        Route::post('/partner/expectation', 'User\HomeController@partnerExpectation')->name('partnerExpectation');
        Route::post('/spiritual/social/background', 'User\HomeController@spiritualSocialBg')->name('spiritualSocialBg');

        // religion-caste-subcaste dependency dropdown
        Route::post('get-caste-by-religion', 'User\HomeController@getCaste')->name('getCaste');
        Route::post('get-sub-caste-by-caste', 'User\HomeController@getSubCaste')->name('getSubCaste');

        // country-state-city dependency dropdown
        Route::get('get-all-country', 'User\CountryStateCityController@getCountry');
        Route::post('get-states-by-country', 'User\CountryStateCityController@getState')->name('states');
        Route::post('get-cities-by-state', 'User\CountryStateCityController@getCity')->name('cities');

        // education info
        Route::post('/education/info/create', 'User\EducationInfoController@educationInfoCreate')->name('educationInfoCreate');
        Route::put('/education/info/update/{id}', 'User\EducationInfoController@educationInfoUpdate')->name('educationInfoUpdate');
        Route::delete('/education/info/delete/{id}', 'User\EducationInfoController@educationInfoDelete')->name('educationInfoDelete');

        // career info
        Route::post('/career/info/create', 'User\CareerInfoController@careerInfoCreate')->name('careerInfoCreate');
        Route::put('/career/info/update/{id}', 'User\CareerInfoController@careerInfoUpdate')->name('careerInfoUpdate');
        Route::delete('/career/info/delete/{id}', 'User\CareerInfoController@careerInfoDelete')->name('careerInfoDelete');

        Route::post('/updatePassword', 'User\HomeController@updatePassword')->name('updatePassword');

        Route::post('/verificationSubmit', 'User\HomeController@verificationSubmit')->name('verificationSubmit');
        Route::post('/addressVerification', 'User\HomeController@addressVerification')->name('addressVerification');


        // Support Ticket
        Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
            Route::get('/', 'User\SupportController@index')->name('list');
            Route::get('/create', 'User\SupportController@create')->name('create');
            Route::post('/create', 'User\SupportController@store')->name('store');
            Route::get('/view/{ticket}', 'User\SupportController@ticketView')->name('view');
            Route::put('/reply/{ticket}', 'User\SupportController@reply')->name('reply');
            Route::get('/download/{ticket}', 'User\SupportController@download')->name('download');
        });


    });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Admin\LoginController@login')->name('login');
    Route::post('/logout', 'Admin\LoginController@logout')->name('logout');


    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');


    Route::get('/403', 'Admin\DashboardController@forbidden')->name('403');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');

        Route::get('/profile', 'Admin\DashboardController@profile')->name('profile');
        Route::put('/profile', 'Admin\DashboardController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\DashboardController@password')->name('password');
        Route::put('/password', 'Admin\DashboardController@passwordUpdate')->name('passwordUpdate');


        Route::get('/staff', 'Admin\ManageRolePermissionController@staff')->name('staff');
        Route::post('/staff', 'Admin\ManageRolePermissionController@storeStaff')->name('storeStaff');
        Route::put('/staff/{id}', 'Admin\ManageRolePermissionController@updateStaff')->name('updateStaff');

        /* ====== Reported Members =====*/
        Route::get('/reported/members', 'Admin\UsersController@reportList')->name('reportList');
        Route::get('/reported/members/search', 'Admin\UsersController@reportListSearch')->name('reportList.search');
        Route::delete('/reported/members/delete/{id}', 'Admin\UsersController@reportDelete')->name('report.delete');

        /* ====== Transaction Log =====*/
        Route::get('/transaction', 'Admin\LogController@transaction')->name('transaction');
        Route::get('/transaction-search', 'Admin\LogController@transactionSearch')->name('transaction.search');


        /*====Manage Users ====*/
        Route::get('/users', 'Admin\UsersController@index')->name('users');
        Route::get('/users/search', 'Admin\UsersController@search')->name('users.search');
        Route::post('/users-active', 'Admin\UsersController@activeMultiple')->name('user-multiple-active');
        Route::post('/users-inactive', 'Admin\UsersController@inactiveMultiple')->name('user-multiple-inactive');
        Route::get('/user/edit/{id}', 'Admin\UsersController@userEdit')->name('user-edit');
        Route::post('/user/update/{id}', 'Admin\UsersController@userUpdate')->name('user-update');
        Route::post('/user/password/{id}', 'Admin\UsersController@passwordUpdate')->name('userPasswordUpdate');
        Route::post('/user/balance-update/{id}', 'Admin\UsersController@userBalanceUpdate')->name('user-balance-update');

        Route::get('/user/send-email/{id}', 'Admin\UsersController@sendEmail')->name('send-email');
        Route::post('/user/send-email/{id}', 'Admin\UsersController@sendMailUser')->name('user.email-send');
        Route::get('/user/transaction/{id}', 'Admin\UsersController@transaction')->name('user.transaction');
        Route::get('/user/fundLog/{id}', 'Admin\UsersController@funds')->name('user.fundLog');
        Route::get('/user/referralMember/{id}', 'Admin\UsersController@referralMember')->name('user.referralMember');
        Route::post('/admin/login/as/user/{id}', 'Admin\UsersController@loginAsUser')->name('login-as-user');


        Route::get('/email-send', 'Admin\UsersController@emailToUsers')->name('email-send');
        Route::post('/email-send', 'Admin\UsersController@sendEmailToUsers')->name('email-send.store');

        // user profile make approve/pending
        Route::put('/users/profile/approve/{id}', 'Admin\UsersController@profileApprove')->name('profile-approve');
        Route::put('/users/profile/pending/{id}', 'Admin\UsersController@profilePending')->name('profile-pending');


        /* ================= Admin Profile Attribute Management ===================== */

        /* ===== Admin On Behalf Management ===== */
        Route::get('/onBehalf/List', 'Admin\OnBehalfController@onBehalfList')->name('onBehalfList');
        Route::get('/onBehalf/create', 'Admin\OnBehalfController@onBehalfCreate')->name('onBehalfCreate');
        Route::post('/onBehalf/store/{language?}', 'Admin\OnBehalfController@onBehalfStore')->name('onBehalfStore');
        Route::get('/onBehalf/edit/{id}', 'Admin\OnBehalfController@onBehalfEdit')->name('onBehalfEdit');
        Route::put('/onBehalf/update/{id}/{language?}', 'Admin\OnBehalfController@onBehalfUpdate')->name('onBehalfUpdate');
        Route::delete('/onBehalf/delete/{id}', 'Admin\OnBehalfController@onBehalfDelete')->name('onBehalfDelete');

        /* ===== Admin Hair-Color Management ===== */
        Route::get('/hairColor/List', 'Admin\HairColorController@hairColorList')->name('hairColorList');
        Route::get('/hairColor/create', 'Admin\HairColorController@hairColorCreate')->name('hairColorCreate');
        Route::post('/hairColor/store/{language?}', 'Admin\HairColorController@hairColorStore')->name('hairColorStore');
        Route::get('/hairColor/edit/{id}', 'Admin\HairColorController@hairColorEdit')->name('hairColorEdit');
        Route::put('/hairColor/update/{id}/{language?}', 'Admin\HairColorController@hairColorUpdate')->name('hairColorUpdate');
        Route::delete('/hairColor/delete/{id}', 'Admin\HairColorController@hairColorDelete')->name('hairColorDelete');

        /* ===== Admin Complexion Management ===== */
        Route::get('/complexion/List', 'Admin\ComplexionController@complexionList')->name('complexionList');
        Route::get('/complexion/create', 'Admin\ComplexionController@complexionCreate')->name('complexionCreate');
        Route::post('/complexion/store/{language?}', 'Admin\ComplexionController@complexionStore')->name('complexionStore');
        Route::get('/complexion/edit/{id}', 'Admin\ComplexionController@complexionEdit')->name('complexionEdit');
        Route::put('/complexion/update/{id}/{language?}', 'Admin\ComplexionController@complexionUpdate')->name('complexionUpdate');
        Route::delete('/complexion/delete/{id}', 'Admin\ComplexionController@complexionDelete')->name('complexionDelete');

        /* ===== Admin Body Type Management ===== */
        Route::get('/bodyType/List', 'Admin\BodyTypeController@bodyTypeList')->name('bodyTypeList');
        Route::get('/bodyType/create', 'Admin\BodyTypeController@bodyTypeCreate')->name('bodyTypeCreate');
        Route::post('/bodyType/store/{language?}', 'Admin\BodyTypeController@bodyTypeStore')->name('bodyTypeStore');
        Route::get('/bodyType/edit/{id}', 'Admin\BodyTypeController@bodyTypeEdit')->name('bodyTypeEdit');
        Route::put('/bodyType/update/{id}/{language?}', 'Admin\BodyTypeController@bodyTypeUpdate')->name('bodyTypeUpdate');
        Route::delete('/bodyType/delete/{id}', 'Admin\BodyTypeController@bodyTypeDelete')->name('bodyTypeDelete');

        /* ===== Admin Body Art Management ===== */
        Route::get('/bodyArt/List', 'Admin\BodyArtController@bodyArtList')->name('bodyArtList');
        Route::get('/bodyArt/create', 'Admin\BodyArtController@bodyArtCreate')->name('bodyArtCreate');
        Route::post('/bodyArt/store/{language?}', 'Admin\BodyArtController@bodyArtStore')->name('bodyArtStore');
        Route::get('/bodyArt/edit/{id}', 'Admin\BodyArtController@bodyArtEdit')->name('bodyArtEdit');
        Route::put('/bodyArt/update/{id}/{language?}', 'Admin\BodyArtController@bodyArtUpdate')->name('bodyArtUpdate');
        Route::delete('/bodyArt/delete/{id}', 'Admin\BodyArtController@bodyArtDelete')->name('bodyArtDelete');

        /* ===== Admin Ethnicity Management ===== */
        Route::get('/ethnicity/List', 'Admin\EthnicityController@ethnicityList')->name('ethnicityList');
        Route::get('/ethnicity/create', 'Admin\EthnicityController@ethnicityCreate')->name('ethnicityCreate');
        Route::post('/ethnicity/store/{language?}', 'Admin\EthnicityController@ethnicityStore')->name('ethnicityStore');
        Route::get('/ethnicity/edit/{id}', 'Admin\EthnicityController@ethnicityEdit')->name('ethnicityEdit');
        Route::put('/ethnicity/update/{id}/{language?}', 'Admin\EthnicityController@ethnicityUpdate')->name('ethnicityUpdate');
        Route::delete('/ethnicity/delete/{id}', 'Admin\EthnicityController@ethnicityDelete')->name('ethnicityDelete');

        /* ===== Admin Personal Value Management ===== */
        Route::get('/personalValue/List', 'Admin\PersonalValueController@personalValueList')->name('personalValueList');
        Route::get('/personalValue/create', 'Admin\PersonalValueController@personalValueCreate')->name('personalValueCreate');
        Route::post('/personalValue/store/{language?}', 'Admin\PersonalValueController@personalValueStore')->name('personalValueStore');
        Route::get('/personalValue/edit/{id}', 'Admin\PersonalValueController@personalValueEdit')->name('personalValueEdit');
        Route::put('/personalValue/update/{id}/{language?}', 'Admin\PersonalValueController@personalValueUpdate')->name('personalValueUpdate');
        Route::delete('/personalValue/delete/{id}', 'Admin\PersonalValueController@personalValueDelete')->name('personalValueDelete');

        /* ===== Admin Personal Value Management ===== */
        Route::get('/communityValue/List', 'Admin\CommunityValueController@communityValueList')->name('communityValueList');
        Route::get('/communityValue/create', 'Admin\CommunityValueController@communityValueCreate')->name('communityValueCreate');
        Route::post('/communityValue/store/{language?}', 'Admin\CommunityValueController@communityValueStore')->name('communityValueStore');
        Route::get('/communityValue/edit/{id}', 'Admin\CommunityValueController@communityValueEdit')->name('communityValueEdit');
        Route::put('/communityValue/update/{id}/{language?}', 'Admin\CommunityValueController@communityValueUpdate')->name('communityValueUpdate');
        Route::delete('/communityValue/delete/{id}', 'Admin\CommunityValueController@communityValueDelete')->name('communityValueDelete');

        /* ===== Admin Political View Management ===== */
        Route::get('/politicalView/List', 'Admin\PoliticalViewController@politicalViewList')->name('politicalViewList');
        Route::get('/politicalView/create', 'Admin\PoliticalViewController@politicalViewCreate')->name('politicalViewCreate');
        Route::post('/politicalView/store/{language?}', 'Admin\PoliticalViewController@politicalViewStore')->name('politicalViewStore');
        Route::get('/politicalView/edit/{id}', 'Admin\PoliticalViewController@politicalViewEdit')->name('politicalViewEdit');
        Route::put('/politicalView/update/{id}/{language?}', 'Admin\PoliticalViewController@politicalViewUpdate')->name('politicalViewUpdate');
        Route::delete('/politicalView/delete/{id}', 'Admin\PoliticalViewController@politicalViewDelete')->name('politicalViewDelete');

        /* ===== Admin Religious Service Management ===== */
        Route::get('/religiousService/List', 'Admin\ReligiousServiceController@religiousServiceList')->name('religiousServiceList');
        Route::get('/religiousService/create', 'Admin\ReligiousServiceController@religiousServiceCreate')->name('religiousServiceCreate');
        Route::post('/religiousService/store/{language?}', 'Admin\ReligiousServiceController@religiousServiceStore')->name('religiousServiceStore');
        Route::get('/religiousService/edit/{id}', 'Admin\ReligiousServiceController@religiousServiceEdit')->name('religiousServiceEdit');
        Route::put('/religiousService/update/{id}/{language?}', 'Admin\ReligiousServiceController@religiousServiceUpdate')->name('religiousServiceUpdate');
        Route::delete('/religiousService/delete/{id}', 'Admin\ReligiousServiceController@religiousServiceDelete')->name('religiousServiceDelete');

        /* ===== Admin Affection For Management ===== */
        Route::get('/affectionFor/List', 'Admin\AffectionForController@affectionForList')->name('affectionForList');
        Route::get('/affectionFor/create', 'Admin\AffectionForController@affectionForCreate')->name('affectionForCreate');
        Route::post('/affectionFor/store/{language?}', 'Admin\AffectionForController@affectionForStore')->name('affectionForStore');
        Route::get('/affectionFor/edit/{id}', 'Admin\AffectionForController@affectionForEdit')->name('affectionForEdit');
        Route::put('/affectionFor/update/{id}/{language?}', 'Admin\AffectionForController@affectionForUpdate')->name('affectionForUpdate');
        Route::delete('/affectionFor/delete/{id}', 'Admin\AffectionForController@affectionForDelete')->name('affectionForDelete');

        /* ===== Admin Affection For Management ===== */
        Route::get('/humor/List', 'Admin\HumorController@humorList')->name('humorList');
        Route::get('/humor/create', 'Admin\HumorController@humorCreate')->name('humorCreate');
        Route::post('/humor/store/{language?}', 'Admin\HumorController@humorStore')->name('humorStore');
        Route::get('/humor/edit/{id}', 'Admin\HumorController@humorEdit')->name('humorEdit');
        Route::put('/humor/update/{id}/{language?}', 'Admin\HumorController@humorUpdate')->name('humorUpdate');
        Route::delete('/humor/delete/{id}', 'Admin\HumorController@humorDelete')->name('humorDelete');

        /* ===== Admin Marital Status Management ===== */
        Route::get('/maritalStatus/List', 'Admin\MaritalStatusController@maritalStatusList')->name('maritalStatusList');
        Route::get('/maritalStatus/create', 'Admin\MaritalStatusController@maritalStatusCreate')->name('maritalStatusCreate');
        Route::post('/maritalStatus/store/{language?}', 'Admin\MaritalStatusController@maritalStatusStore')->name('maritalStatusStore');
        Route::get('/maritalStatus/edit/{id}', 'Admin\MaritalStatusController@maritalStatusEdit')->name('maritalStatusEdit');
        Route::put('/maritalStatus/update/{id}/{language?}', 'Admin\MaritalStatusController@maritalStatusUpdate')->name('maritalStatusUpdate');
        Route::delete('/maritalStatus/delete/{id}', 'Admin\MaritalStatusController@maritalStatusDelete')->name('maritalStatusDelete');

        /* ===== Admin Family Value Management ===== */
        Route::get('/familyValue/List', 'Admin\FamilyValueController@familyValueList')->name('familyValueList');
        Route::get('/familyValue/create', 'Admin\FamilyValueController@familyValueCreate')->name('familyValueCreate');
        Route::post('/familyValue/store/{language?}', 'Admin\FamilyValueController@familyValueStore')->name('familyValueStore');
        Route::get('/familyValue/edit/{id}', 'Admin\FamilyValueController@familyValueEdit')->name('familyValueEdit');
        Route::put('/familyValue/update/{id}/{language?}', 'Admin\FamilyValueController@familyValueUpdate')->name('familyValueUpdate');
        Route::delete('/familyValue/delete/{id}', 'Admin\FamilyValueController@familyValueDelete')->name('familyValueDelete');

        /* ===== Admin Religion Manage ===== */
        Route::get('/religion/List', 'Admin\ReligionController@religionList')->name('religionList');
        Route::get('/religion/create', 'Admin\ReligionController@religionCreate')->name('religionCreate');
        Route::post('/religion/store', 'Admin\ReligionController@religionStore')->name('religionStore');
        Route::get('/religion/edit/{id}', 'Admin\ReligionController@religionEdit')->name('religionEdit');
        Route::put('/religion/update/{id}', 'Admin\ReligionController@religionUpdate')->name('religionUpdate');
        Route::delete('/religion/delete/{id}', 'Admin\ReligionController@religionDelete')->name('religionDelete');

        /* ===== Admin Caste Manage ===== */
        Route::get('/caste/List', 'Admin\ReligionController@casteList')->name('casteList');
        Route::get('/caste/create', 'Admin\ReligionController@casteCreate')->name('casteCreate');
        Route::post('/caste/store', 'Admin\ReligionController@casteStore')->name('casteStore');
        Route::get('/caste/edit/{id}', 'Admin\ReligionController@casteEdit')->name('casteEdit');
        Route::put('/caste/update/{id}', 'Admin\ReligionController@casteUpdate')->name('casteUpdate');
        Route::delete('/caste/delete/{id}', 'Admin\ReligionController@casteDelete')->name('casteDelete');

        /* ===== Admin Sub-Caste Manage ===== */
        Route::get('/sub-caste/List', 'Admin\ReligionController@subCasteList')->name('subCasteList');
        Route::get('/sub-caste/create', 'Admin\ReligionController@subCasteCreate')->name('subCasteCreate');
        Route::post('/sub-caste/store', 'Admin\ReligionController@subCasteStore')->name('subCasteStore');
        Route::get('/sub-caste/edit/{id}', 'Admin\ReligionController@subCasteEdit')->name('subCasteEdit');
        Route::put('/sub-caste/update/{id}', 'Admin\ReligionController@subCasteUpdate')->name('subCasteUpdate');
        Route::delete('/sub-caste/delete/{id}', 'Admin\ReligionController@subCasteDelete')->name('subCasteDelete');


        /* ===== Admin Country Manage ===== */
        Route::get('/country/List', 'Admin\CountryController@countryList')->name('countryList');
        Route::get('/country/create', 'Admin\CountryController@countryCreate')->name('countryCreate');
        Route::post('/country/store', 'Admin\CountryController@countryStore')->name('countryStore');
        Route::get('/country/edit/{id}', 'Admin\CountryController@countryEdit')->name('countryEdit');
        Route::put('/country/update/{id}', 'Admin\CountryController@countryUpdate')->name('countryUpdate');
        Route::delete('/country/delete/{id}', 'Admin\CountryController@countryDelete')->name('countryDelete');

        /* ===== Admin State Manage ===== */
        Route::get('/state/List', 'Admin\CountryController@stateList')->name('stateList');
        Route::get('/state/create', 'Admin\CountryController@stateCreate')->name('stateCreate');
        Route::post('/state/store', 'Admin\CountryController@stateStore')->name('stateStore');
        Route::get('/state/edit/{id}', 'Admin\CountryController@stateEdit')->name('stateEdit');
        Route::put('/state/update/{id}', 'Admin\CountryController@stateUpdate')->name('stateUpdate');
        Route::delete('/state/delete/{id}', 'Admin\CountryController@stateDelete')->name('stateDelete');
        Route::get('/state/search', 'Admin\CountryController@stateSearch')->name('state.search');

        /* ===== Admin City Manage ===== */
        Route::get('/city/List', 'Admin\CountryController@cityList')->name('cityList');
        Route::get('/city/create', 'Admin\CountryController@cityCreate')->name('cityCreate');
        Route::post('/city/store', 'Admin\CountryController@cityStore')->name('cityStore');
        Route::get('/city/edit/{id}', 'Admin\CountryController@cityEdit')->name('cityEdit');
        Route::put('/city/update/{id}', 'Admin\CountryController@cityUpdate')->name('cityUpdate');
        Route::delete('/city/delete/{id}', 'Admin\CountryController@cityDelete')->name('cityDelete');
        Route::get('/city/search', 'Admin\CountryController@citySearch')->name('city.search');


        /*=====Payment Log=====*/
        Route::get('payment-methods', 'Admin\PaymentMethodController@index')->name('payment.methods');
        Route::post('payment-methods/deactivate', 'Admin\PaymentMethodController@deactivate')->name('payment.methods.deactivate');
        Route::get('payment-methods/deactivate', 'Admin\PaymentMethodController@deactivate')->name('payment.methods.deactivate');
        Route::post('sort-payment-methods', 'Admin\PaymentMethodController@sortPaymentMethods')->name('sort.payment.methods');
        Route::get('payment-methods/edit/{id}', 'Admin\PaymentMethodController@edit')->name('edit.payment.methods');
        Route::put('payment-methods/update/{id}', 'Admin\PaymentMethodController@update')->name('update.payment.methods');


        // Manual Methods
        Route::get('payment-methods/manual', 'Admin\ManualGatewayController@index')->name('deposit.manual.index');
        Route::get('payment-methods/manual/new', 'Admin\ManualGatewayController@create')->name('deposit.manual.create');
        Route::post('payment-methods/manual/new', 'Admin\ManualGatewayController@store')->name('deposit.manual.store');
        Route::get('payment-methods/manual/edit/{id}', 'Admin\ManualGatewayController@edit')->name('deposit.manual.edit');
        Route::put('payment-methods/manual/update/{id}', 'Admin\ManualGatewayController@update')->name('deposit.manual.update');


        Route::get('payment/pending', 'Admin\PaymentLogController@pending')->name('payment.pending');
        Route::put('payment/action/{id}', 'Admin\PaymentLogController@action')->name('payment.action');
        Route::get('payment/log', 'Admin\PaymentLogController@index')->name('payment.log');
        Route::get('payment/search', 'Admin\PaymentLogController@search')->name('payment.search');


        /* ===== Support Ticket ====*/
        Route::get('tickets/{status?}', 'Admin\TicketController@tickets')->name('ticket');
        Route::get('tickets/view/{id}', 'Admin\TicketController@ticketReply')->name('ticket.view');
        Route::put('ticket/reply/{id}', 'Admin\TicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'Admin\TicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'Admin\TicketController@ticketDelete')->name('ticket.delete');

        /* ===== Subscriber =====*/
        Route::get('subscriber', 'Admin\SubscriberController@index')->name('subscriber.index');
        Route::post('subscriber/remove', 'Admin\SubscriberController@remove')->name('subscriber.remove');
        Route::get('subscriber/send-email', 'Admin\SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/send-email', 'Admin\SubscriberController@sendEmail')->name('subscriber.mail');


        /* ===== website controls =====*/
        Route::any('/basic-controls', 'Admin\BasicController@index')->name('basic-controls');
        Route::post('/basic-controls', 'Admin\BasicController@updateConfigure')->name('basic-controls.update');

        Route::any('/email-controls', 'Admin\EmailTemplateController@emailControl')->name('email-controls');
        Route::post('/email-controls', 'Admin\EmailTemplateController@emailConfigure')->name('email-controls.update');
        Route::post('/email-controls/action', 'Admin\EmailTemplateController@emailControlAction')->name('email-controls.action');
        Route::post('/email/test', 'Admin\EmailTemplateController@testEmail')->name('testEmail');

        Route::get('/email-template', 'Admin\EmailTemplateController@show')->name('email-template.show');
        Route::get('/email-template/edit/{id}', 'Admin\EmailTemplateController@edit')->name('email-template.edit');
        Route::post('/email-template/update/{id}', 'Admin\EmailTemplateController@update')->name('email-template.update');

        /*========Sms control ========*/
        Route::match(['get', 'post'], '/sms-controls', 'Admin\SmsTemplateController@smsConfig')->name('sms.config');
        Route::post('/sms-controls/action', 'Admin\SmsTemplateController@smsControlAction')->name('sms-controls.action');
        Route::get('/sms-template', 'Admin\SmsTemplateController@show')->name('sms-template');
        Route::get('/sms-template/edit/{id}', 'Admin\SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('/sms-template/update/{id}', 'Admin\SmsTemplateController@update')->name('sms-template.update');

        Route::get('/notify-config', 'Admin\NotifyController@notifyConfig')->name('notify-config');
        Route::post('/notify-config', 'Admin\NotifyController@notifyConfigUpdate')->name('notify-config.update');
        Route::get('/notify-template', 'Admin\NotifyController@show')->name('notify-template.show');
        Route::get('/notify-template/edit/{id}', 'Admin\NotifyController@edit')->name('notify-template.edit');
        Route::post('/notify-template/update/{id}', 'Admin\NotifyController@update')->name('notify-template.update');


        /* ===== ADMIN Language SETTINGS ===== */
        Route::get('language', 'Admin\LanguageController@index')->name('language.index');
        Route::get('language/create', 'Admin\LanguageController@create')->name('language.create');
        Route::post('language/create', 'Admin\LanguageController@store')->name('language.store');
        Route::get('language/{language}', 'Admin\LanguageController@edit')->name('language.edit');
        Route::put('language/{language}', 'Admin\LanguageController@update')->name('language.update');
        Route::delete('language/{language}', 'Admin\LanguageController@delete')->name('language.delete');
        Route::get('/language/keyword/{id}', 'Admin\LanguageController@keywordEdit')->name('language.keywordEdit');
        Route::put('/language/keyword/{id}', 'Admin\LanguageController@keywordUpdate')->name('language.keywordUpdate');
        Route::post('/language/importJson', 'Admin\LanguageController@importJson')->name('language.importJson');
        Route::post('store-key/{id}', 'Admin\LanguageController@storeKey')->name('language.storeKey');
        Route::put('update-key/{id}', 'Admin\LanguageController@updateKey')->name('language.updateKey');
        Route::delete('delete-key/{id}', 'Admin\LanguageController@deleteKey')->name('language.deleteKey');


        Route::get('/logo-seo', 'Admin\BasicController@logoSeo')->name('logo-seo');
        Route::put('/logoUpdate', 'Admin\BasicController@logoUpdate')->name('logoUpdate');
        Route::put('/seoUpdate', 'Admin\BasicController@seoUpdate')->name('seoUpdate');
        Route::get('/breadcrumb', 'Admin\BasicController@breadcrumb')->name('breadcrumb');
        Route::put('/breadcrumb', 'Admin\BasicController@breadcrumbUpdate')->name('breadcrumbUpdate');


        /* ===== ADMIN TEMPLATE SETTINGS ===== */
        Route::get('template/{section}', 'Admin\TemplateController@show')->name('template.show');
        Route::put('template/{section}/{language}', 'Admin\TemplateController@update')->name('template.update');
        Route::get('contents/{content}', 'Admin\ContentController@index')->name('content.index');
        Route::get('content-create/{content}', 'Admin\ContentController@create')->name('content.create');
        Route::put('content-create/{content}/{language?}', 'Admin\ContentController@store')->name('content.store');
        Route::get('content-show/{content}/{name?}', 'Admin\ContentController@show')->name('content.show');
        Route::put('content-update/{content}/{language?}', 'Admin\ContentController@update')->name('content.update');
        Route::delete('contents/{id}', 'Admin\ContentController@contentDelete')->name('content.delete');


        Route::get('push-notification-show', 'SiteNotificationController@showByAdmin')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAllByAdmin')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');
        Route::match(['get', 'post'], 'pusher-config', 'SiteNotificationController@pusherConfig')->name('pusher.config');


        /* ===== Admin Blog Management ===== */
        Route::get('/blog/category', 'Admin\BlogController@categoryList')->name('blogCategory');
        Route::get('/blog/category/create', 'Admin\BlogController@blogCategoryCreate')->name('blogCategoryCreate');
        Route::post('/blog/category/store/{language?}', 'Admin\BlogController@blogCategoryStore')->name('blogCategoryStore');
        Route::get('/blog/category/edit/{id}', 'Admin\BlogController@blogCategoryEdit')->name('blogCategoryEdit');
        Route::put('/blog/category/update/{id}/{language?}', 'Admin\BlogController@blogCategoryUpdate')->name('blogCategoryUpdate');
        Route::delete('/blog/category/delete/{id}', 'Admin\BlogController@blogCategoryDelete')->name('blogCategoryDelete');

        Route::get('/blog/list', 'Admin\BlogController@blogList')->name('blogList');
        Route::get('/blog/create', 'Admin\BlogController@blogCreate')->name('blogCreate');
        Route::post('/blog/store/{language?}', 'Admin\BlogController@blogStore')->name('blogStore');
        Route::get('/blog/edit/{id}', 'Admin\BlogController@blogEdit')->name('blogEdit');
        Route::put('/blog/update/{id}/{language?}', 'Admin\BlogController@blogUpdate')->name('blogUpdate');
        Route::delete('/blog/delete/{id}', 'Admin\BlogController@blogDelete')->name('blogDelete');


        /*====== Admin Manage Plan =======*/
        Route::get('/plan-list', 'Admin\PlanController@plan')->name('planList');
        Route::get('/plan-create', 'Admin\PlanController@planCreate')->name('planCreate');
        Route::post('/plan-store/{language?}', 'Admin\PlanController@planStore')->name('planStore');
        Route::get('/plan-edit/{id}', 'Admin\PlanController@planEdit')->name('planEdit');
        Route::put('/plan-update/{id}/{language?}', 'Admin\PlanController@planUpdate')->name('planUpdate');
        Route::delete('/plan-delete/{id}', 'Admin\PlanController@planDelete')->name('planDelete');

        // sold plan
        Route::get('/sold/planList', 'Admin\PlanController@soldPlanList')->name('sold.planList');
        Route::get('/sold/plan/search', 'Admin\PlanController@soldPlanSearch')->name('soldPlan.search');


        /*====== Admin Manage Story =======*/
        Route::get('/story-list', 'Admin\UsersController@storytList')->name('storyList');
        Route::get('/story/search', 'Admin\UsersController@storySearch')->name('story.search');
        Route::get('/story-show/{id}', 'Admin\UsersController@storyShow')->name('storyShow');
        Route::put('/story-approve/{id}', 'Admin\UsersController@storyApprove')->name('storyApprove');
        Route::put('/story-pending/{id}', 'Admin\UsersController@storyPending')->name('storyPending');
        Route::delete('/story-delete/{id}', 'Admin\UsersController@storyDelete')->name('storyDelete');


        /* ======== Plugin =======*/
        Route::get('/plugin-config', 'Admin\BasicController@pluginConfig')->name('plugin.config');
        Route::match(['get', 'post'], 'tawk-config', 'Admin\BasicController@tawkConfig')->name('tawk.control');
        Route::match(['get', 'post'], 'fb-messenger-config', 'Admin\BasicController@fbMessengerConfig')->name('fb.messenger.control');
        Route::match(['get', 'post'], 'google-recaptcha', 'Admin\BasicController@googleRecaptchaConfig')->name('google.recaptcha.control');
        Route::match(['get', 'post'], 'google-analytics', 'Admin\BasicController@googleAnalyticsConfig')->name('google.analytics.control');

    });


});


Route::match(['get', 'post'], 'success', 'PaymentController@success')->name('success');
Route::match(['get', 'post'], 'failed', 'PaymentController@failed')->name('failed');
Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', 'PaymentController@gatewayIpn')->name('ipn');


Route::get('/language/{code?}', 'FrontendController@language')->name('language');


//--blog--
Route::get('/blog', 'FrontendController@blog')->name('blog');
Route::get('/blog-details/{slug}/{id}', 'FrontendController@blogDetails')->name('blogDetails');
Route::get('/category/wise/blog/{slug}/{id}', 'FrontendController@CategoryWiseBlog')->name('CategoryWiseBlog');
Route::get('/blog/search', 'FrontendController@blogSearch')->name('blogSearch');

Route::get('/category', 'FrontendController@category')->name('category');
Route::get('/listing-details', 'FrontendController@listing_details')->name('listing-details');
Route::get('/blog-details/{slug}/{id}', 'FrontendController@blogDetails')->name('blogDetails');


Route::get('/', 'FrontendController@index')->name('home');
Route::get('/about', 'FrontendController@about')->name('about');
Route::get('/faq', 'FrontendController@faq')->name('faq');
Route::get('/plan', 'FrontendController@planList')->name('plan');
Route::get('/members', 'FrontendController@members')->name('members');

// Search member
Route::get('/search/member', 'FrontendController@searchMember')->name('user.search.member');

Route::get('add/shortlist/{member_id}', 'User\ShortlistController@updateShortist');
Route::get('add/interest/{member_id}', 'User\InterestController@updateInterest');
Route::get('add/ignore/{member_id}', 'User\IgnoreController@ignoreMember');

Route::get('/story', 'FrontendController@story')->name('story');
Route::get('/story-details/{slug?}/{id}', 'FrontendController@storyDetails')->name('storyDetails');

Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', 'FrontendController@contactSend')->name('contact.send');

Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

Route::get('/{getLink}/{content_id}', 'FrontendController@getLink')->name('getLink');




