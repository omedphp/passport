<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Omed\Passport\Http\Controllers\Profile\ProfileController;

Route::group(['prefix' => 'profile', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ProfileController::class, 'view'])->name('profile.view');
    Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/email', [ProfileController::class, 'updateEmail'])->name('profile.update_email');
    Route::post('/password', [ProfileController::class, 'changePassword'])->name('profile.change_password');
});
