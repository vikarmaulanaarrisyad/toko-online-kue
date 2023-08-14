<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Date;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Membuat data dumy untuk login
        $admin = new User;
        $admin->name = 'Administrator';
        $admin->email = 'admin@gmail.com';
        $admin->password = '$2y$10$Em9.WL.miABER9M0Ku2Puei7dm1/B2Lo6CPjIIM3AGz3So0N/Ziw.'; //000000
        $admin->path_image = 'default.jpg';
        $admin->remember_token = Str::random(10);
        $admin->email_verified_at = Date('Y-m-d H:i:s');
        $admin->phone = Str::random(12);
        $admin->role_id = 1;
        $admin->save();
    }
}
