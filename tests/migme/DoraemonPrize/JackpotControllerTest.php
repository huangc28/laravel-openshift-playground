<?php

class JackpotControllerTest extends TestCase
{
	/**
	 * @todo table truncate should be moved to "JiraTicketTestCase"
	 */
	public function setUp()
	{
		parent::setUp();
		DB::table('jira_ticket')->truncate();
		DB::table('users')->truncate();
		$this->seed('UserTableSeeder');
	}

	public function tearDown()
	{
		DB::table('jira_ticket')->truncate();
		DB::table('users')->truncate();
	}

	/**
	 * Try request 'jackpot-it' url and test response.
	 */
	public function test_request_run_jackpot()
	{
		$response = $this->call('GET', '/jackpot-it');	

		var_dump($response->getContent());
		// die;

		// $this->assertEquals('email has been sent to the winner', $response->getContent());

		
		// var_dump(\Schema::hasTable('jira_ticket'));
		// $tickets = \DB::table('jira_ticket')->get();
		// var_dump($tickets);
		// $this->assertEquals('email has been sent to the winner', $response->getContent());
	}

	public function test_request_test_route()
	{
		$response = $this->call('GET', '/jackpot-it-test');

		var_dump($response->getContent());
	}

	/**
	 * Uses "mandrill" as the mail driver.
	 */
	public function test_email_sending()
	{
		Mail::send('emails.sample_email', [], function($m){
			$m->from('bryan.ch.h@mig.me', 'Laravel');
			$m->to('bryan.ch.h@mig.me', 'Bryan Huang')->subject('sample email');
		});
	}
}