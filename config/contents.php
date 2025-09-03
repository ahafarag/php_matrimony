<?php
return [
    'feature' => [
        'field_name' => [
            'title' => 'text',
            'information' => 'text',
            'icon' => 'icon',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'information.*' => 'required|max:100',
            'icon.*' => 'required|max:100',
        ]
    ],

    'testimonial' => [
        'field_name' => [
            'name' => 'text',
            'relation' => 'text',
            'description' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'relation.*' => 'required|max:30',
            'description.*' => 'required|max:1000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '100x100'
        ]
    ],

    'counter' => [
        'field_name' => [
            'title' => 'text',
            'number' => 'text'
        ],
        'validation' => [
            'title.*' => 'required|max:190',
            'number.*' => 'required|integer'
        ]
    ],

    'faq' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:190',
            'description.*' => 'required|max:3000'
        ]
    ],

    'social' => [
        'field_name' => [
            'name' => 'text',
            'icon' => 'icon',
            'link' => 'url',
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'icon.*' => 'required|max:100',
            'link.*' => 'required|max:100'
        ],
    ],

    'support' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'description.*' => 'required|max:3000'
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
        'integer' => 'This field must be an integer value',
    ],

    'content_media' => [
        'image' => 'file',
        'thumbnail' => 'file',
        'youtube_link' => 'url',
        'button_link' => 'url',
        'link' => 'url',
        'icon' => 'icon'
    ]
];
