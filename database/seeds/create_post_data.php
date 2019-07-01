<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class create_post_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //require_once 'vendor/fzaninotto/faker/src/autoload.php';
        //$faker =Faker\Factory::create('ja_JP');
        //$faker->name."\n";
        //->address

        for($i=1;$i<=20;$i++){
            $username = array("admin","Eugene","test01","test02","test03");
            $data[] = [
                'body' => 'Hi,i am data_'.Str::random(10),
                'user' => array_random($username),
                'created_at' =>  date('Y-m-d',strtotime( '-'.mt_rand(0,30).' days')),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('posts')->insert($data);
    }
}
