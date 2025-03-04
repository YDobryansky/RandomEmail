<?php
/**
 * OnGage Notify configuration.
 */
return [
    'login' => env('ONGAGE_NOTIFY_LOGIN'),
    'password' => env('ONGAGE_NOTIFY_PASSWORD'),
    'account_code' => env('ONGAGE_NOTIFY_ACCOUNT_CODE'),
    'base_url' => env('ONGAGE_NOTIFY_BASE_URL', 'https://api.ongage.net/{list_id}/api/v2'),
    'list_id' => env('ONGAGE_NOTIFY_LIST_ID'),
];
