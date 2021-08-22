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

namespace Omed\Passport\Http\Controllers\Passport;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\ClientRepository;
use Omed\Passport\Http\Controllers\Controller;
use Omed\Passport\Models\User;

class LoginController extends Controller
{
    public function login(Request $request, ClientRepository $clientRepository): Response
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if ($user) {
            if (Hash::check((string) $request->password, (string) $user->password)) {
                $token    = $user->createToken('password');
                /** @var Carbon $expiresIn */
                $expiresIn = $token->token->expires_at;
                $response = [
                    'token' => $token->accessToken,
                    'expires' => $expiresIn,
                    'message' => 'Your token has been created'
                ];
                cookie()->queue(
                    'token',
                    $token->accessToken,
                    14400,
                    null,
                    null,
                    true,
                    true
                );
                return response($response, 200);
            }
        }

        return $this->badCredentialsResponse();
    }

    private function badCredentialsResponse(): Response
    {
        return response(['message' => 'Bad Credentials'], 422);
    }
}
