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

namespace Omed\Passport;

use Illuminate\Foundation\Application as BaseApplication;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Application extends BaseApplication
{
    public function __construct(string $basePath = null)
    {
        $this->namespace = 'Omed\\Passport';
        $this->appPath   = __DIR__;
        parent::__construct($basePath);
    }
}
