<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'authors' => 'c,r,u,d',
            'departments' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'newspaper' => 'c,r,u,d',
            'articles' => 'c,r,u,d'
        ],
        'writer' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
