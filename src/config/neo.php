<?php

// convert CSV to array
$allowedRoles = env('NEO_AUTH_ROLES', '');
if (empty($allowedRoles)) {
    $allowedRoles = [];
} else {
    $allowedRoles = explode(',', $allowedRoles);
    $allowedRoles = array_map(function ($id) {
        return intval(trim($id));
    }, $allowedRoles);
}

return [
    'auth' => [
        'allowedRoles' => $allowedRoles
    ]
];