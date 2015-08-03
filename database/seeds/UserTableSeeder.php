<?php

use Illuminate\Database\Seeder;
// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Note: 'name' is the reference for $jiraTickt->assignee. 
     */
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');

        // 'name' is the reference for $jiraTicket->assignee
        // @example
        DB::table('users')->insert([
            'mig_id'     => 'achi.c',
            'name'       => 'Achi Chen',
            'email'      => 'achi.c@mig.me', 
            'password'   => '1234',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        DB::table('users')->insert([
            'mig_id' => 'andre.l',  
            'name'   => 'Andre Lee',
            'email'  => 'andre.l@mig.me',
            'password'   => '1234',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        DB::table('users')->insert([
            'mig_id' => 'bryan.ch.h',
            'name'   => 'bryan.ch.h', 
            'email'  => 'bryan.ch.h@mig.me',
            'password' => '1234',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

        DB::table('users')->insert([
            'mig_id' => 'damiano.t',
            'name'   => 'Damiano Tietto',
            'email'  => 'damiano.t@mig.me',
            'password' => '1234',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
