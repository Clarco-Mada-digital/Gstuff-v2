<?php

return [
    // Titles and labels
    'page_title' => 'Contact',
    'contact_us' => 'Contact Us',
    'make_comment' => 'Make a Comment',
    'need_info' => 'Need information or advice? Contact us now!',
    'comment' => 'Comment',
    'message_placeholder' => 'Message',
    'send' => 'Send',
    'name' => 'Name',
    'name_placeholder' => 'Your name',
    'email' => 'Email',
    'email_placeholder' => 'your@email.com',
    'subject' => 'Subject',
    'subject_placeholder' => 'Message subject',
    'message' => 'Message',
    'message_placeholder' => 'Your message...',
    
    // Success/error messages
    'success' => [
        'message_sent' => 'Your message has been sent successfully!',
    ],
    'errors' => [
        'sending_failed' => 'An error occurred while sending your message. Please try again later.',
    ],
    
    // Validation messages
    'validation' => [
        'name' => [
            'required' => 'The name field is required',
            'string' => 'The name must be a string',
            'max' => 'The name may not be greater than :max characters',
        ],
        'email' => [
            'required' => 'The email field is required',
            'email' => 'Please enter a valid email address',
            'max' => 'The email may not be greater than :max characters',
        ],
        'subject' => [
            'required' => 'The subject field is required',
            'string' => 'The subject must be a string',
            'max' => 'The subject may not be greater than :max characters',
        ],
        'message' => [
            'required' => 'The message field is required',
            'string' => 'The message must be a string',
            'max' => 'The message may not be greater than :max0 characters',
        ],
    ],
];
