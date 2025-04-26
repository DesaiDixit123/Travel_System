<?php

return [
 

        'defaults' => [
            'guard' => 'corporate', // Optional: set default guard
            'passwords' => 'corporates', // Correct 'passwords' provider name
        ],
    
        'guards' => [
            'corporate' => [
                'driver' => 'session',
                'provider' => 'corporates', // Make sure this is correctly pointing to your provider
            ],
        ],
     
        'providers' => [
            'corporates' => [
                'driver' => 'eloquent',
                'model' => App\Models\Corporate::class, // Ensure this is using the correct model
            ],
        ],
    
        'passwords' => [
            'corporates' => [
                'provider' => 'corporates', // Match the provider here as well
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ],
    
 


       
    
];
