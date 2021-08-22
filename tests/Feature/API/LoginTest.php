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
 */
class LoginTest extends TestCase
{
    use InteractsWithPassportClient;
    use RefreshDatabase;

    public function test_should_handle_api_login()
    {
        $this->createPersonalAccessClient();
        $user     = User::factory()->create();
        $response = $this->post('/api/passport/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }
}
