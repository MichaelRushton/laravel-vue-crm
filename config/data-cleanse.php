<?php

declare(strict_types=1);

// The number of days to retain the records
return [
    'customer_revisions' => env('DATA_CLEANSE_CUSTOMER_REVISIONS', 365),
    'password_resets' => env('DATA_CLEANSE_PASSWORD_RESETS', 365),
    'sign_ins' => env('DATA_CLEANSE_SIGN_INS', 365),
    'user_impersonations' => env('DATA_CLEANSE_USER_IMPERSONATIONS', 365),
    'user_revisions' => env('DATA_CLEANSE_USER_REVISIONS', 365),
];
