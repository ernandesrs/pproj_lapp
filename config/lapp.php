<?php

return [

    'front' => [
        'urls' => [
            'base' => env('FRONT_URL_BASE'),
            'register_verification' => env('FRONT_URL_REGISTER_VERIFICATION'),
            'update_password' => env('FRONT_URL_UPDATE_PASSWORD')
        ]
    ],



    /**
     * 
     * User
     * 
     */
    'user' => [
        /**
         * 
         * User fields and rules
         * 
         * This rules can be used in this class request and in UserUpdateRequest class
         * 
         * the 'unique' rule must always be the last in the array
         * 
         */
        'fields_and_rules' => [
            'first_name' => ['required', 'max:25'],
            'last_name' => ['required', 'max:50'],
            'username' => ['required', 'max:25', 'unique:users,username'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:12', 'confirmed']
        ]
    ]

];