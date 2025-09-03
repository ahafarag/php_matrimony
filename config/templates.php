<?php
return [
    'hero' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'button_name' => 'text',
            'button_link' => 'url',
            'left_image' => 'file',
            'right_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:700',
            'button_name.*' => 'required|max:2000',
            'button_link.*' => 'required|max:2000',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png',
            'right_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'left_image' => '375x375',
            'right_image' => '500x500'
        ]
    ],

    'feature' => [
        'field_name' => [
            'title' => 'text',
            'left_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'nullable|max:100',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'left_image' => '300x291'
        ]
    ],

    'about-us' => [
        'field_name' => [
            'title' => 'text',
            'short_description' => 'textarea',
            'left_image' => 'file',
            'right_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_description.*' => 'required|max:2000',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png',
            'right_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'left_image' => '466x655',
            'right_image' => '371x332'
        ]
    ],

    'package' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'right_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:700',
            'right_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'right_image' => '300x413'
        ]
    ],

    'story' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'right_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:700',
            'right_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'right_image' => '300x413'
        ]
    ],

    'premium-member' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'left_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:700',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'left_image' => '300x413'
        ]
    ],

    'testimonial' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'left_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:700',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'left_image' => '300x413'
        ]
    ],

    'counter' => [
        'field_name' => [
            'title' => 'text',
            'right_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'nullable|max:100',
            'right_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'right_image' => '300x293'
        ]
    ],

    'news-letter' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:2000'
        ]
    ],

    'blog' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:2000',
        ]
    ],

    'contact-us' => [
        'field_name' => [
            'email_one' => 'text',
            'email_two' => 'text',
            'phone_one' => 'text',
            'phone_two' => 'text',
            'address' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'address.*' => 'required|max:2000',
            'email_one.*' => 'required|max:30',
            'email_two.*' => 'required|max:30',
            'phone_one.*' => 'required|max:18',
            'phone_two.*' => 'required|max:18',
            'image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '440x268'
        ]
    ],

    'footer' => [
        'field_name' => [
            'title' => 'text',
            'left_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'nullable|max:30',
            'left_image.*' => 'required|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'left_image' => '300x268'
        ]
    ],

    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => [
            'file' => 'This image may not be greater than :max kilobytes.',
            'string' => 'The field may not be greater than :max characters.',
        ],
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
    ],

    'template_media' => [
        'image' => 'file',
        'left_image' => 'file',
        'right_image' => 'file',
        'thumbnail' => 'file',
        'youtube_link' => 'url',
        'button_link' => 'url',
    ]
];
