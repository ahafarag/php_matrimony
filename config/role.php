<?php

$arr = [
    'dashboard' => [
        'label' => "Dashboard",
        'access' => [
            'view' => ['admin.dashboard'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ],
    ],
    
    'manage_staff' =>[
        'label' => "Manage Staff",
        'access' => [
            'view' => ['admin.staff'],
            'add' => ['admin.storeStaff'],
            'edit' => ['admin.updateStaff'],
            'delete' => [],
        ],
    ],

    'plan' => [
        'label' => "Manage Plan",
        'access' => [
            'view' => ['admin.planList'],
            'add' => ['admin.planCreate'],
            'edit' => ['admin.planEdit'],
            'delete' => ['admin.planDelete']
        ],
    ],

    'plan_sold' => [
        'label' => "Sold Plan",
        'access' => [
            'view' => ['admin.sold.planList','admin.soldPlan.search'],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ],
    ],


    'story' => [
        'label' => "Story List",
        'access' => [
            'view' => ['admin.storyList','admin.story.search'],
            'add' => [],
            'edit' => ['admin.storyApprove','admin.storyPending'],
            'delete' => ['admin.storyDelete']
        ],
    ],


    'report_list' => [
        'label' => "Report List",
        'access' => [
            'view' => ['admin.reportList','admin.reportList.search'],
            'add' => [],
            'edit' => [],
            'delete' => ['admin.report.delete']
        ],
    ],


    'all_transaction' => [
        'label' => "All Transaction",
        'access' => [
            'view' => [
                'admin.transaction',
                'admin.transaction.search',
            ],
            'add' => [],
            'edit' => [],
            'delete' => [],
        ],
    ],


    'user_management' => [
        'label' => "User Management",
        'access' => [
            'view' => [
                'admin.users',
                'admin.users.search',
                'admin.email-send',
                'admin.user.transaction',
                'admin.user.fundLog',
                'admin.user.withdrawal',
//                'admin.user.userKycHistory',
//                'admin.kyc.users.pending',
//                'admin.kyc.users',
                'admin.user-edit',
                'admin.onBehalfList',
                'admin.maritalStatusList',
                'admin.familyValueList',
                'admin.religionList',
                'admin.casteList',
                'admin.subCasteList',
                'admin.countryList',
                'admin.stateList',
                'admin.cityList',
            ],
            'add' => [
                'admin.onBehalfCreate',
                'admin.maritalStatusCreate',
                'admin.familyValueCreate',
                'admin.religionCreate',
                'admin.casteCreate',
                'admin.subCasteCreate',
                'admin.countryCreate',
                'admin.stateCreate',
                'admin.cityCreate',
            ],
            'edit' => [
                'admin.user-multiple-active',
                'admin.user-multiple-inactive',
                'admin.send-email',
//                'admin.user.userKycHistory',
                'admin.user-balance-update',
                'admin.onBehalfEdit',
                'admin.maritalStatusEdit',
                'admin.familyValueEdit',
                'admin.religionEdit',
                'admin.casteEdit',
                'admin.subCasteEdit',
                'admin.countryEdit',
                'admin.stateEdit',
                'admin.cityEdit',
            ],
            'delete' => [
                'admin.onBehalfDelete',
                'admin.maritalStatusDelete',
                'admin.familyValueDelete',
                'admin.religionDelete',
                'admin.casteDelete',
                'admin.subCasteDelete',
                'admin.countryDelete',
                'admin.stateDelete',
                'admin.cityDelete',
            ],
        ],
    ],


    'payment_gateway' => [
        'label' => "Payment Gateway",
        'access' => [
            'view' => [
                'admin.payment.methods',
                'admin.deposit.manual.index',
            ],
            'add' => [
                'admin.deposit.manual.create'
            ],
            'edit' => [
                'admin.edit.payment.methods',
                'admin.deposit.manual.edit'
            ],
            'delete' => [],
        ],
    ],

    'payment_log' => [
        'label' => "Payment Request & Log",
        'access' => [
            'view' => [
                'admin.payment.pending',
                'admin.payment.log',
                'admin.payment.search',
            ],
            'add' => [],
            'edit' => [
                'admin.payment.action'
            ],
            'delete' => [],
        ],
    ],



    'support_ticket' => [
        'label' => "Support Ticket",
        'access' => [
            'view' => [
                'admin.ticket',
                'admin.ticket.view',
            ],
            'add' => [
                'admin.ticket.reply'
            ],
            'edit' => [],
            'delete' => [
                'admin.ticket.delete',
            ],
        ],
    ],

    'subscriber' => [
        'label' => "Subscriber",
        'access' => [
            'view' => [
                'admin.subscriber.index',
                'admin.subscriber.sendEmail',
            ],
            'add' => [],
            'edit' => [],
            'delete' => [
                'admin.subscriber.remove'
            ],
        ],
    ],

    'website_controls' => [
        'label' => "Website Controls",
        'access' => [
            'view' => [
                'admin.basic-controls',
                'admin.email-controls',
                'admin.email-template.show',
                'admin.sms.config',
                'admin.sms-template',
                'admin.notify-config',
                'admin.notify-template.show',
                'admin.notify-template.edit',
            ],
            'add' => [],
            'edit' => [
                'admin.basic-controls.update',
                'admin.email-controls.update',
                'admin.email-template.edit',
                'admin.sms-template.edit',
                'admin.notify-config.update',
                'admin.notify-template.update',
            ],
            'delete' => [],
        ],
    ],

    'language_settings' => [
        'label' => "Language Settings",
        'access' => [
            'view' => [
                'admin.language.index',
            ],
            'add' => [
                'admin.language.create',
            ],
            'edit' => [
                'admin.language.edit',
                'admin.language.keywordEdit',
            ],
            'delete' => [
                'admin.language.delete'
            ],
        ],
    ],


    'theme_settings' =>  [
        'label' => "Theme Settings",
        'access' => [
            'view' => [
                'admin.manage.theme',
                'admin.logo-seo',
                'admin.breadcrumb',
                'admin.template.show',
                'admin.content.index',
                'admin.blogCategory',
                'admin.blogList',
            ],
            'add' => [
                'admin.content.create',
                'admin.blogCategoryCreate',
                'admin.blogCreate',
            ],
            'edit' => [
                'admin.logoUpdate',
                'admin.seoUpdate',
                'admin.breadcrumbUpdate',
                'admin.content.show',
                'admin.blogCategoryEdit',
                'admin.blogEdit',
            ],
            'delete' => [
                'admin.content.delete',
                'admin.blogCategoryDelete',
                'admin.blogDelete',
            ],
        ],
    ],

];

return $arr;



