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
