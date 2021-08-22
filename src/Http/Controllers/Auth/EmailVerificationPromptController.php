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

namespace Omed\Passport\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Omed\Passport\Http\Controllers\Controller;
use Omed\Passport\Models\User;
use Omed\Passport\Providers\RouteServiceProvider;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return $user->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
