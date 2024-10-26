<?php

use Illuminate\Support\Facades\Route;
use Shaz3e\EmailTemplates\App\Http\Controllers\EmailTemplateController;

Route::middleware($middleware = config('email-templates.middleware', ['web','auth']))
    ->prefix(config('email-templates.url_prefix', 'manage'))
    ->name(config('email-templates.route_prefix', 'admin') . '.')
    ->group(function () {
        Route::resource('email-templates', EmailTemplateController::class);
    });
