<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class create_admin_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $img = array("/image/1.jpg","/image/2.jpg","/image/3.jpg","/image/4.jpg");
        DB::table('users')->insert([
            'name' => 'Eugene',
            'email' => 'ilvinchan95@hotmail.com',
            'password' => bcrypt('Hotdilvin95'),
            'img' => array_random($img),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@hotmail.com',
            'password' => bcrypt('Hotdilvin95'),
            'img' => array_random($img),
        ]);
        DB::table('users')->insert([
            'name' => 'test01',
            'email' => 'test01@hotmail.com',
            'password' => bcrypt('Hotdilvin95'),
            'img' => array_random($img),
        ]);
        DB::table('users')->insert([
            'name' => 'test02',
            'email' => 'test02@hotmail.com',
            'password' => bcrypt('Hotdilvin95'),
            'img' => array_random($img),
        ]);
        DB::table('users')->insert([
            'name' => 'test03',
            'email' => 'test03@hotmail.com',
            'password' => bcrypt('Hotdilvin95'),
            'img' => array_random($img),
        ]);
        DB::table('follow_users')->insert([
            'follow_to' => 'admin',
            'follow_by' => 'Eugene',
        ]);
        DB::table('follow_users')->insert([
            'follow_to' => 'test03',
            'follow_by' => 'Eugene',
        ]);
    }
}
