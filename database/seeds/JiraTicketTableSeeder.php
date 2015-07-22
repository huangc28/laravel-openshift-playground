<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class JiraTicketTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        DB::table('jira_ticket')->insert([
        	'ticket_id'	  => '100',
        	'ticket_no'   => '10000',
            'assignee_jira_id'=> 'bryan.ch.c',
        	'jackpot_hit' => false     
        ]);

        DB::table('jira_ticket')->insert([
        	'ticket_id'	  => '101',
        	'ticket_no'   => '10001',
            'assignee_jira_id'=> 'andre.l',
        	'jackpot_hit' => false     
        ]);

        DB::table('jira_ticket')->insert([
        	'ticket_id'	  => '102',
        	'ticket_no'   => '10002',
            'assignee_jira_id'=> 'bryan.ch.c',
        	'jackpot_hit' => false     
        ]);

        DB::table('jira_ticket')->insert([
        	'ticket_id'	  => '103',
        	'ticket_no'   => '10003',
            'assignee_jira_id'=> 'achi.c',
        	'jackpot_hit' => false     
        ]);
        
        DB::table('jira_ticket')->insert([
        	'ticket_id'	  => '104',
        	'ticket_no'   => '10004',
            'assignee_jira_id'=> 'damiano.t',
        	'jackpot_hit' => false     
        ]);
    }
}
