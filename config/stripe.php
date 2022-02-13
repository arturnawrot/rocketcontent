<?php

return [
    'stripe_key' => env('STRIPE_KEY'),
    'stripe_secret' => env('STRIPE_SECRET'),

    'error_messages' => [
        'invalid_request' => 'There were some issues with processing your request to the payment processor. Please, try again later, or contact the customer service.',
        'card_exception' => 'Your card was declined. Please, contact customer service.',
        'exception' => 'There were some issues with processing your request to the payment processor. Please, try again later, or contact the customer service.',
    ],

    'exceptions' => [
        [
            'exception' => \Stripe\Exception\InvalidRequestException::class,
            'type' => 'invalid_request'
        ],
        [
            'exception' => \Stripe\Exception\ApiErrorException::class,
            'type' => 'invalid_request'
        ],
        [
            'exception' => \Stripe\Exception\ApiConnectionException::class,
            'type' => 'invalid_request'
        ],
        [
            'exception' => \Stripe\Exception\CardException::class,
            'type' => 'card_exception'
        ]
    ]
];