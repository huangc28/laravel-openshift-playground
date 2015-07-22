<?php

use App\JiraUserRepository; 
use App\JiraTicket;
use App\User;

/**
 * 1. seed jira candidates info to DB.
 * 2. retrieve jira tickets.
 *
 */
class JiraUserRepositoryTest extends TestCase
{
	public function setUp()
	{
		parent::setUp(); 
		$this->seed('UserTableSeeder');
		$this->seed('JiraTicketTableSeeder');
	}

	public function tearDown()
	{
		DB::table('users')->truncate();
		DB::table('jira_ticket')->truncate();
	}

	/**
	 * Test sync jira tickets with users.
	 *
	 * 
	 */
	public function test_jira_user_repository_sync_tickets()
	{
		// create three new tickets
		$ticket_1 = JiraTicket::create([
			'ticket_id'  => '2000',
			'ticket_no'  => '20000',
			'jackpot_hit'=> false
		]);

		$ticket_2 = JiraTicket::create([
			'ticket_id'  => '2001', 
			'ticket_no'  => '20001',
			'jackpot_hit'
		]);

		$userRepo = new JiraUserRepository(new User);
		$userRepo->syncTickets($tickets);

		// assert each user has been related to specified ticket.
		$user = User::where('mig_id', 'achi.c')->first();
		$tickets = $user->jiraTicket;
		var_dump($tickets);
		// var_dump($user);
		die;

	}
}