<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(adminAccessRoute(config('role.dashboard.access.view')))
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.dashboard')}}" aria-expanded="false">
                            <i data-feather="home" class="feather-icon text-indigo"></i>
                            <span class="hide-menu">@lang('Dashboard')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(array_merge(config('role.plan.access.view'), config('role.plan_sold.access.view'))))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Package')</span></li>
                    @if(adminAccessRoute(config('role.plan.access.view')))
                        <li class="sidebar-item {{menuActive(['admin.planList','admin.planCreate','admin.planEdit*'],3)}}">
                            <a class="sidebar-link" href="{{route('admin.planList')}}" aria-expanded="false">
                                <i class="fas fa-cubes text-info"></i>
                                <span class="hide-menu">@lang('Package List')</span>
                            </a>
                        </li>
                    @endif

                    @if(adminAccessRoute(config('role.plan_sold.access.view')))
                        <li class="sidebar-item {{menuActive(['admin.sold.planList','admin.soldPlan.search'],3)}}">
                            <a class="sidebar-link" href="{{route('admin.sold.planList')}}" aria-expanded="false">
                                <i class="fas fa-cart-arrow-down text-purple"></i>
                                <span class="hide-menu">@lang('Sold Packages')</span>
                            </a>
                        </li>
                    @endif
                @endif



                @if(adminAccessRoute(config('role.user_management.access.view')))
                    {{--Manage User--}}
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage User')</span></li>

                    <li class="sidebar-item {{menuActive(['admin.users','admin.users.search','admin.user-edit*','admin.send-email*','admin.user*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.users') }}" aria-expanded="false">
                            <i class="fas fa-users text-dark"></i>
                            <span class="hide-menu">@lang('All User')</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*','admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*','admin.complexionList','admin.complexionCreate','admin.complexionEdit*','admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*','admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*','admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*','admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*','admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*','admin.personalValueList','admin.personalValueCreate','admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*','admin.personalValueEdit*','admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*','admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*','admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*','admin.humorList','admin.humorCreate','admin.humorEdit*','admin.religionList','admin.religionCreate','admin.religionEdit*','admin.casteList','admin.casteCreate','admin.casteEdit*','admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*','admin.countryList','admin.countryCreate','admin.countryEdit*','admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*','admin.cityList', 'admin.city.search','admin.cityCreate','admin.cityEdit*'],3)}}">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-cogs text-red"></i>
                            <span class="hide-menu">@lang('Profile Attributes')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*','admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*','admin.complexionList','admin.complexionCreate','admin.complexionEdit*','admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*','admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*','admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*','admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*', 'admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*','admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*','admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*','admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*','admin.religionList','admin.religionCreate','admin.religionEdit*','admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*','admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*','admin.humorList','admin.humorCreate','admin.humorEdit*','admin.casteList','admin.casteCreate','admin.casteEdit*','admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*','admin.countryList','admin.countryCreate','admin.countryEdit*','admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*','admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.cityEdit*'],1)}}">

                            <li class="sidebar-item {{menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*'])}}">
                                <a href="{{route('admin.onBehalfList')}}"
                                   class="sidebar-link {{menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*'])}}">
                                    <span class="hide-menu">@lang('On Behalf')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*'])}}">
                                <a href="{{route('admin.hairColorList')}}"
                                   class="sidebar-link {{menuActive(['admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*'])}}">
                                    <span class="hide-menu">@lang('Hair Color')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.complexionList','admin.complexionCreate','admin.complexionEdit*'])}}">
                                <a href="{{route('admin.complexionList')}}"
                                   class="sidebar-link {{menuActive(['admin.complexionList','admin.complexionCreate','admin.complexionEdit*'])}}">
                                    <span class="hide-menu">@lang('Complexion')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*'])}}">
                                <a href="{{route('admin.bodyTypeList')}}"
                                   class="sidebar-link {{menuActive(['admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*'])}}">
                                    <span class="hide-menu">@lang('Body Type')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*'])}}">
                                <a href="{{ route('admin.maritalStatusList') }}"
                                   class="sidebar-link {{menuActive(['admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*'])}}">
                                    <span class="hide-menu">@lang('Marital Status')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*'])}}">
                                <a href="{{route('admin.bodyArtList')}}"
                                   class="sidebar-link {{menuActive(['admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*'])}}">
                                    <span class="hide-menu">@lang('Body Art')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*'])}}">
                                <a href="{{ route('admin.familyValueList') }}"
                                   class="sidebar-link {{menuActive(['admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*'])}}">
                                    <span class="hide-menu">@lang('Family Value')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*'])}}">
                                <a href="{{ route('admin.ethnicityList') }}"
                                   class="sidebar-link {{menuActive(['admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*'])}}">
                                    <span class="hide-menu">@lang('Ethnicity')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*'])}}">
                                <a href="{{ route('admin.personalValueList') }}"
                                   class="sidebar-link {{menuActive(['admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*'])}}">
                                    <span class="hide-menu">@lang('Personal Value')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*'])}}">
                                <a href="{{ route('admin.politicalViewList') }}"
                                   class="sidebar-link {{menuActive(['admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*'])}}">
                                    <span class="hide-menu">@lang('Political View')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*'])}}">
                                <a href="{{ route('admin.religiousServiceList') }}"
                                   class="sidebar-link {{menuActive(['admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*'])}}">
                                    <span class="hide-menu">@lang('Religious Service')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*'])}}">
                                <a href="{{ route('admin.affectionForList') }}"
                                   class="sidebar-link {{menuActive(['admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*'])}}">
                                    <span class="hide-menu">@lang('Affection For')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.humorList','admin.humorCreate','admin.humorEdit*'])}}">
                                <a href="{{ route('admin.humorList') }}"
                                   class="sidebar-link {{menuActive(['admin.humorList','admin.humorCreate','admin.humorEdit*'])}}">
                                    <span class="hide-menu">@lang('Humor')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])}}">
                                <a href="{{ route('admin.communityValueList') }}"
                                   class="sidebar-link {{menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])}}">
                                    <span class="hide-menu">@lang('Community Value')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.religionList','admin.religionCreate','admin.religionEdit*'])}}">
                                <a href="{{ route('admin.religionList') }}"
                                   class="sidebar-link {{menuActive(['admin.religionList','admin.religionCreate','admin.religionEdit*'])}}">
                                    <span class="hide-menu">@lang('Religion')</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{menuActive(['admin.casteList','admin.casteCreate','admin.casteEdit*'])}}">
                                <a href="{{ route('admin.casteList') }}"
                                   class="sidebar-link {{menuActive(['admin.casteList','admin.casteCreate','admin.casteEdit*'])}}">
                                    <span class="hide-menu">@lang('Caste')</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{menuActive(['admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*'])}}">
                                <a href="{{ route('admin.subCasteList') }}"
                                   class="sidebar-link {{menuActive(['admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*'])}}">
                                    <span class="hide-menu">@lang('Sub-Caste')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.countryList','admin.countryCreate','admin.countryEdit*'])}}">
                                <a href="{{ route('admin.countryList') }}"
                                   class="sidebar-link {{menuActive(['admin.countryList','admin.countryCreate','admin.countryEdit*'])}}">
                                    <span class="hide-menu">@lang('Country')</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{menuActive(['admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*'])}}">
                                <a href="{{ route('admin.stateList') }}"
                                   class="sidebar-link {{menuActive(['admin.stateList','admin.stateCreate', 'admin.state.search', 'admin.stateEdit*'])}}">
                                    <span class="hide-menu">@lang('State')</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{menuActive(['admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.city.search','admin.cityEdit*'])}}">
                                <a href="{{ route('admin.cityList') }}"
                                   class="sidebar-link {{menuActive(['admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.cityEdit*'])}}">
                                    <span class="hide-menu">@lang('City')</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.email-send') }}"
                           aria-expanded="false">
                            <i class="fas fa-envelope-open text-info"></i>
                            <span class="hide-menu">@lang('Send Email')</span>
                        </a>
                    </li>
                @endif

                @if(adminAccessRoute(config('role.report_list.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Profile Reports')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.reportList*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.reportList') }}" aria-expanded="false">
                            <i class="fas fa-ban text-danger"></i>
                            <span class="hide-menu">@lang('Reported Members')</span>
                        </a>
                    </li>
                @endif
                @if(adminAccessRoute(config('role.story.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Story')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.storyList','admin.storyShow','admin.story.search'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.storyList') }}" aria-expanded="false">
                            <i class="fas fa-handshake text-orange"></i>
                            <span class="hide-menu">@lang('Story List')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.all_transaction.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('All Transaction ')</span></li>

                    <li class="sidebar-item {{menuActive(['admin.transaction*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.transaction') }}" aria-expanded="false">
                            <i class="fas fa-exchange-alt text-purple"></i>
                            <span class="hide-menu">@lang('Transaction')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.payment_gateway.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Payment Settings')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.payment.methods','admin.edit.payment.methods'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.methods')}}"
                           aria-expanded="false">
                            <i class="fas fa-credit-card text-red"></i>
                            <span class="hide-menu">@lang('Payment Methods')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.deposit.manual.index')}}"
                           aria-expanded="false">
                            <i class="fa fa-university text-orange"></i>
                            <span class="hide-menu">@lang('Manual Gateway')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.payment_log.access.view')))
                    <li class="sidebar-item {{menuActive(['admin.payment.pending'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.pending')}}" aria-expanded="false">
                            <i class="fas fa-spinner text-primary"></i>
                            <span class="hide-menu">@lang('Payment Request')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.payment.log','admin.payment.search'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.log')}}" aria-expanded="false">
                            <i class="fas fa-history text-warning"></i>
                            <span class="hide-menu">@lang('Payment Log')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.support_ticket.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Support Tickets')</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.ticket')}}" aria-expanded="false">
                            <i class="fas fa-ticket-alt text-info"></i>
                            <span class="hide-menu">@lang('All Tickets')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['open']) }}"
                           aria-expanded="false">
                            <i class="fas fa-spinner text-teal"></i>
                            <span class="hide-menu">@lang('Open Ticket')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['closed']) }}"
                           aria-expanded="false">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span class="hide-menu">@lang('Closed Ticket')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['answered']) }}"
                           aria-expanded="false">
                            <i class="fas fa-reply text-green"></i>
                            <span class="hide-menu">@lang('Answered Ticket')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.subscriber.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Subscriber')</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.subscriber.index')}}" aria-expanded="false">
                            <i class="fas fa-thumbs-up text-teal"></i>
                            <span class="hide-menu">@lang('Subscriber List')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.manage_staff.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Admin Accessibility')</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.staff')}}" aria-expanded="false">
                            <i class="fa fa-users-cog text-indigo"></i>
                            <span class="hide-menu">@lang('Role Permission')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(array_merge(config('role.website_controls.access.view'), config('role.language_settings.access.view'))))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Controls')</span></li>

                    @if(adminAccessRoute(config('role.website_controls.access.view')))
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.basic-controls')}}" aria-expanded="false">
                                <i class="fas fa-cogs text-primary"></i>
                                <span class="hide-menu">@lang('Basic Controls')</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-envelope text-success"></i>
                                <span class="hide-menu">@lang('Email Settings')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.email-controls')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Email Controls')</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('admin.email-template.show')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Email Template') </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-mobile-alt text-danger"></i>
                                <span class="hide-menu">@lang('SMS Settings')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.sms.config') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('SMS Controls')</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="{{ route('admin.sms-template') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('SMS Template')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-bell text-purple"></i>
                                <span class="hide-menu">@lang('Push Notification')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.notify-config')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Configuration')</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="{{ route('admin.notify-template.show') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Template')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="sidebar-item {{menuActive(['admin.plugin.config','admin.tawk.control','admin.fb.messenger.control','admin.google.recaptcha.control','admin.google.analytics.control'],3)}}">
                            <a class="sidebar-link" href="{{route('admin.plugin.config')}}" aria-expanded="false">
                                <i class="fas fa-toolbox text-indigo"></i>
                                <span class="hide-menu">@lang('Plugin Configuration')</span>
                            </a>
                        </li>


                    @endif
                    @if(adminAccessRoute(config('role.language_settings.access.view')))
                        <li class="sidebar-item {{menuActive(['admin.language.create','admin.language.edit*','admin.language.keywordEdit*'],3)}}">
                            <a class="sidebar-link" href="{{  route('admin.language.index') }}"
                               aria-expanded="false">
                                <i class="fas fa-language text-teal"></i>
                                <span class="hide-menu">@lang('Manage Language')</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if(adminAccessRoute(config('role.theme_settings.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Theme Settings')</span></li>


                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.logo-seo')}}" aria-expanded="false">
                            <i class="fas fa-image text-info"></i><span
                                class="hide-menu">@lang('Manage Logo & SEO')</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.breadcrumb')}}" aria-expanded="false">
                            <i class="fas fa-file-image text-indigo"></i><span
                                class="hide-menu">@lang('Manage Breadcrumb')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*','admin.blogList','admin.blogCreate','admin.blogEdit*'],3)}}">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-book-reader text-gray-dark"></i>
                            <span class="hide-menu">@lang('Manage Blog')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*','admin.blogList','admin.blogCreate','admin.blogEdit*'],1)}}">

                            <li class="sidebar-item {{menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*'])}}">
                                <a href="{{route('admin.blogCategory')}}"
                                   class="sidebar-link {{menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*'])}}">
                                    <span class="hide-menu">@lang('Blog Category')</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{menuActive(['admin.blogList','admin.blogCreate','admin.blogEdit*'])}}">
                                <a href="{{ route('admin.blogList') }}"
                                   class="sidebar-link {{menuActive(['admin.blogList','admin.blogCreate','admin.blogEdit*'])}}">
                                    <span class="hide-menu">@lang('Blog List')</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="sidebar-item {{menuActive(['admin.template.show*'],3)}}">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-indigo"></i>
                            <span class="hide-menu">@lang('Section Heading')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.template.show*'],1)}}">

                            @foreach(array_diff(array_keys(config('templates')),['message','template_media']) as $name)
                                <li class="sidebar-item {{ menuActive(['admin.template.show'.$name]) }}">
                                    <a class="sidebar-link {{ menuActive(['admin.template.show'.$name]) }}"
                                       href="{{ route('admin.template.show',$name) }}">
                                        <span class="hide-menu">@lang(ucfirst(kebab2Title($name)))</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>


                    @php
                        $segments = request()->segments();
                        $last  = end($segments);
                    @endphp
                    <li class="sidebar-item {{menuActive(['admin.content.create','admin.content.show*'],3)}}">
                        <a class="sidebar-link has-arrow {{Request::routeIs('admin.content.show',$last) ? 'active' : '' }}"
                           href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-teal"></i>
                            <span class="hide-menu">@lang('Content Settings')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.content.create','admin.content.show*'],1)}}">
                            @foreach(array_diff(array_keys(config('contents')),['message','content_media']) as $name)
                                <li class="sidebar-item {{($last == $name) ? 'active' : '' }} ">
                                    <a class="sidebar-link {{($last == $name) ? 'active' : '' }}"
                                       href="{{ route('admin.content.index',$name) }}">
                                        <span class="hide-menu">@lang(ucfirst(kebab2Title($name)))</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                <li class="list-divider"></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
