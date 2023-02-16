<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'ys',
            'email' => 'ys@ys.ys',
            'email_verified_at' => now(),
//             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password' => '$2y$10$59.fSJBvgHDJShGnctHSCuJf3jyudpfDuscjx6Ix.5nEvDstsqKFO',
            'remember_token' => '64Qw1oWehrmNJdnxI3jMpoVFTJ5NMpETM0ffgSfj5tnF4EkkUhJbB2M7hT5z',

        ]);

         \App\Models\User::factory(19)->create();

         \App\Models\Payouts::factory()->create([
             'user_id' => 1,
             'details' => fake()->text(random_int(100,1000)),
//                 json_encode([
//                 'card' => fake('ru')->creditCardDetails(),
//                 'text' => fake('ru')->text(1000)
//             ],JSON_UNESCAPED_UNICODE),
             'amount'=>fake()->randomFloat(2),
             'currency'=>fake()->currencyCode(),
         ]);

        \App\Models\Payouts::factory(19)->create();

    }
}
