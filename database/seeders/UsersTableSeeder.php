<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'email'=>'info@thankastore.com',
                'password'=>Hash::make('Thanka@admin123'),
                'role'=>'admin',
                'status'=>'active',
                'email_verified'=>true,
            ),
            array(
                'name'=>'CyBurning',
                'email'=>'support@cyburning.com',
                'password'=>Hash::make('!ogin@123'),
                'role'=>'admin',
                'status'=>'active',
                'email_verified'=>true,
            ),
            array(
                'name'=>'User',
                'email'=>'user@gmail.com',
                'password'=>Hash::make('1111'),
                'role'=>'user',
                'status'=>'active',
                'email_verified'=>true,
            ),
        );

        DB::table('users')->insert($data);
    }
}
