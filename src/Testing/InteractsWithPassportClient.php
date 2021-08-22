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
    public function createPersonalAccessClient(string $name= 'personal', string $redirect='http://localhost')
    {
        $repository = $this->getClientRepository();
        $client     =  $repository->createPersonalAccessClient(null, $name, $redirect);
        config('passport.personal_access_client.id', $client->id);
        config('passport.personal_access_client.secret', $client->secret);
    }

    /**
     * @psalm-suppress NullArgument
     */
    public function getPasswordGrantClient(
        string $clientName = 'password',
        string $redirect = 'http://localhost',
        string $provider = 'users'
    ): Client {
        $repository = $this->getClientRepository();
        $client     = Client::where('name', $clientName)->first();
        if (null === $client) {
            $client = $repository->createPasswordGrantClient(
                null,
                $clientName,
                $redirect,
                $provider
            );
        }

        return $client;
    }

    public function getClientRepository(): ClientRepository
    {
        return app(ClientRepository::class);
    }
}
