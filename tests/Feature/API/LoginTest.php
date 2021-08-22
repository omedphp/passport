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

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Omed\Passport\Models\User;
use Omed\Passport\Testing\InteractsWithPassportClient;
use Tests\TestCase;

/**
 * @covers \Omed\Passport\Http\Controllers\Passport\LoginController
 * @covers \Omed\Passport\Models\User
 * @covers \Omed\Passport\Providers\AuthServiceProvider
 * @covers \Omed\Passport\Providers\AppServiceProvider
 * @covers \Omed\Passport\Providers\RouteServiceProvider
 * @covers \Omed\Passport\Providers\EventServiceProvider
 * @covers \Omed\Passport\Providers\BroadcastServiceProvider
 * @covers \Omed\Passport\Testing\InteractsWithPassportClient
 */
class LoginTest extends TestCase
{
    use InteractsWithPassportClient;
    use RefreshDatabase;

    public function test_should_handle_api_login()
    {
        $user = User::factory()->create();
        $this->ensurePasswordGrantClient();

        $response = $this->post(route('passport.login'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
}
