<?php
return [
    'scopes' => [
        'read_products',
        'write_products',
        'read_orders',
        'write_orders',
        'read_inventory',
        'write_inventory',
        'read_themes',
        'write_themes',
       'read_fulfillments'
//        'write_fulfillments'
    ],
    'redirect_before_install' => env('APP_URL').'/auth',
	'mail_from' => env('MAIL_FROM')
];