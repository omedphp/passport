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

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Omed\Passport\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
    }

    private function createUsers()
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'Omed Administrator',
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => Hash::make('admin'),
        ]);
        if ('production' !== config('app.env')) {
            User::factory(10)->create();
        }
    }
}
