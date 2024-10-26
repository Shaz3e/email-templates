<?php

return [
    // Path to the layout file
    'layout' => 'components.layouts.app',

    // Section name for content
    'content' => 'content',

    // Section name for styles (optional)
    'styles' => 'styles',

    // Section name for scripts (optional)
    'scripts' => 'scripts',

    // Middleware to protect routes
    // Web middleware is required as this is bieng used for web application
    // auth middleware is required as these routes are procted by authenticated user
    'middleware' => ['web', 'auth', 'locked', 'active', 'verify'],

    'route_prefix' => 'admin',

    'url_prefix' => 'manage',

    'email-template' => [
        'list',
        'create',
        'read',
        'update',
        'delete',
        'restore',
        'force.delete'
    ],
];
