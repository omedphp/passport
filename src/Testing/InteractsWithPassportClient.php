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

namespace Omed\Passport\Testing;

use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

trait InteractsWithPassportClient
{
    /**
     * @psalm-suppress NullArgument
     */
    public function ensurePasswordGrantClient(
        string $clientName = 'password',
        string $redirect = 'http://localhost',
        string $provider = 'users'
    ): Client {
        $client     = Client::where('name', $clientName)->first();
        if (null === $client) {
            $client = Client::factory()->create([
                'id' => config('passport.personal_access_client.id'),
                'secret' => config('passport.personal_access_client.secret'),
                'name' => 'password',
                'redirect' => $redirect,
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
            ]);
        }

        return $client;
    }

    public function getClientRepository(): ClientRepository
    {
        return app(ClientRepository::class);
    }
}
