<?php

return [
    'courses' => [
        'endpoint' => env('RAZORBACKS_COURSES_API', 'http://localhost:8888/courses'),
    ],
    'plans' => [
        'endpoint' => env('RAZORBACK_PLANS_API', 'http://localhost:8888/plans'),
        'token' => env('RAZORBACK_PLANS_TOKEN', 'AuthToken'),
    ],
];
