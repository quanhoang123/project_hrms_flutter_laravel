<?php

return [
    'role_structure' => [
        'superadmin' => [
            'dashboard' => 'r',
            'users'     => 'c,r,u,d',
            'acl'       => 'c,r,u,d',
            'profile'   => 'r,u',
            'nhan-su'   => 'c,r,u,d',
            'hop-dong'  => 'c,r,u,d',
            'quyet-dinh'=> 'c,r,u,d',
            'company'   => 'u',
            'file-manager' => 'u',
            'bai-viet'=>'c,r,u,d',
        ],
        'admin' => [
            'dashboard' => 'r',
            'profile'   => 'r,u',
            'nhan-su'   => 'c,r,u',
            'hop-dong'  => 'c,r,u,d',
            'quyet-dinh'=> 'c,r,u,d',
            'company'   => 'u',
            'file-manager' => 'u',
            'bai-viet'=>'c,r,u,d',
        ],
        'user' => [
            'dashboard' => 'r',
            'profile'   => 'r,u',
            'nhan-su'   => 'r',
            'hop-dong'  => 'r',
            'bai-viet'=>'c,r,u,d',
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
