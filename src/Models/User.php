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

namespace Omed\Passport\Models;

use Database\Factories\OmedUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasUuidTrait;
    use Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory(): OmedUserFactory
    {
        return new OmedUserFactory();
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param string $password
     */
    public function validateForPassportPasswordGrant($password): bool
    {
        /** @var string $currentPassword */
        $currentPassword = $this->getAttribute('password');

        return Hash::check($password, $currentPassword);
    }

    /**
     * Find the user instance for the given username.
     */
    public function findForPassport(string $username): ?self
    {
        return $this->where('username', $username)->first();
    }
}
