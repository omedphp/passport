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

namespace Omed\Passport\Http\Controllers\Profile;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Omed\Passport\Http\Controllers\Controller;
use Omed\Passport\Models\User;

class ProfileController extends Controller
{
    public function view(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->invalidData($validator);
        }

        /** @var User $user */
        $user       = $request->user();
        $user->name = $request->name;
        $user->save();

        return response()->json($request->user());
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return $this->invalidData($validator);
        }

        /** @var User $user */
        $user        = $request->user();
        $user->email = $request->email;
        $user->save();

        return response()->json($user, 202);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:8',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return $this->invalidData($validator);
        }

        /** @var User $user */
        $user = $request->user();

        if (false === Hash::check((string) $request->current_password, (string) $user->password)) {
            return response()->json(['errors' => ['Your current password is invalid']], 422);
        }

        $user->forceFill([
            'password' => Hash::make((string) $request->password),
            'remember_token' => Str::random(60),
        ])->save();

        return response()->json(['message' => 'Password changed'], 202);
    }

    private function invalidData(ValidatorContract $validator): JsonResponse
    {
        return response()->json(['errors' => $validator->errors()->all()], 422);
    }
}
