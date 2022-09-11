<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\user;
use App\Models\Order;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('123456789'),

        ]);
        User::create([
            'first_name'=>'nader' ,
            'last_name'=>'abdou',
            'email' =>'user@gmail.com',
            'phone'=>'01063832811',
            'city'=>'mansoura',
            'date'=>'30/4/2001',
            'code'=>'2222',
            'status'=>'0',
            'role'=>'user',
            'Bank_Number'=>'564541516454121'


           
           

        ]);
        User::create([
            'first_name'=>'ahmed' ,
            'last_name'=>'abdou',
            'email' =>'ahmed@gmail.com',
            'phone'=>'01063832812',
            'city'=>'mansoura',
            'date'=>'2/4/2001',
            'code'=>'3333',
            'status'=>'0',
            'role'=>'service_provider',
            'ID_number'=>'123456789',
            'scope'=>'Legal Services',
            'about'=>'ddsdfdsfd',
            'Bank_Number'=>'56454156454121'
           
           

        ]);
        Order::create([
            'name_main'=>'mm',
        'name_sub'=>'nn',
        'desc'=>'ewdew',
        'code_order'=>'1111',
        'from'=>'121',
        'to'=>'200',
        'GBS'=>'talkh mansoura',
        'file'=>'',
        'user_id'=>'1'
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
