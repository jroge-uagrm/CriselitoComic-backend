<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $user = new User();
            $user->name= "Criselito Pump";
            $user->email = "admin@admin.com";
            $user->password = bcrypt("123");
            $user->available = true;
            $user->role_id = 1;
            $user->save();
        }
    }
}
