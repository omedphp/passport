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

use Omed\Passport\Testing\InteractsWithPassportClient;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use InteractsWithPassportClient;

    public function test_it_should_handle_login(): void
    {
        $passwordClient = $this->getPasswordGrantClient();

        $response = $this->post('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $passwordClient->getAttribute('id'),
            'client_secret' => $passwordClient->getAttribute('secret'),
            'username' => 'admin',
            'password' => 'admin',
            'scope' => '',
        ]);
        $response->assertStatus(200);
    }
}
