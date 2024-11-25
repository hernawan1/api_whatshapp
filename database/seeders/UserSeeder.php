<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name'      => 'Hernawan',
            'no_phone'  => '085784393032',
            'email'     => 'hernawanseptiansyah@gmail.com',
            'password'  => Hash::make('1234578')
        ]);
    }
}
