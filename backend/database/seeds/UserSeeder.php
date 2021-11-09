<?php

use App\User;
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
        if (User::count()) {
            return;
        }

        for($i=1; $i<=10; $i++) {
            $user = new User();
            $user->username = 'user'.$i;
            $user->password = \Illuminate\Support\Facades\Hash::make('password');
            $user->save();
        }
    }
}
