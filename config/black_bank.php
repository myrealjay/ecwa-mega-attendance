<?php

return
[
    'status' => [
        'failed' => 400,
        'internal_error' => 500,
        'not_allowed' => 403,
        'unauthenticated' => 401,
        'success' => 200,
        'not_found' => 404,
        'failed_validation' => 422
    ],
    'maximum_age' => env('MAXIMUM_AGE', 18),
    'minimum_age' => env('MINIMUM_AGE', 10)
];
