<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cookie Jar
    |--------------------------------------------------------------------------
    |
    | The cookie "jar" used by the framework contains all of the cookies that
    | will be sent back to the user with the response. You are free to set any
    | of these values as required by the application.
    |
    */

    'path' => '/',

    'domain' => env('SESSION_DOMAIN', null),

    'secure' => env('SESSION_SECURE', false),

    'http_only' => true,

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

];
