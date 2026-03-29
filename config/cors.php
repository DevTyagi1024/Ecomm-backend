<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // allow all for now
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];