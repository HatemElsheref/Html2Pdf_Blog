<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->name='Hatem Mohamed';
        $user->email='admin@app.com';
        $user->password=bcrypt(12345);
        $user->photo='default-user.png';
        $user->save();
        $user->attachRole('admin');
    }
}
