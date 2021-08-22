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

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Omed\Passport\Models\User;
use Tests\TestCase;

/**
 * @covers \Omed\Passport\Http\Controllers\Profile\ProfileController
 */
class ProfileTest extends TestCase
{
    use InteractsWithAuthentication;
    use RefreshDatabase;

    public function test_it_should_be_protected_routes(): void
    {
        $response = $this->json('get', route('profile.view'));
        $response->assertUnauthorized();
    }

    public function test_view_profile(): void
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user, 'api')->json('get', route('profile.view'));

        $response->assertJson(['id' => $user->id, 'name' => $user->name]);
    }

    public function test_edit_profile(): void
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->post(route('profile.store'), [
                'name' => 'New Name',
            ]);

        $response->assertJson(['name' => 'New Name']);
    }

    public function test_update_email(): void
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->post(route('profile.update_email'), [
                'email' => $newEmail = 'new@email.com',
            ]);

        $response->assertStatus(202);
        $response->assertJson(['email' => $newEmail]);
    }

    public function test_change_password(): void
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->post(route('profile.change_password'), [
                'current_password' => 'password',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $response->assertStatus(202);
        $response->assertJson(['message' => 'Password changed']);
    }
}
