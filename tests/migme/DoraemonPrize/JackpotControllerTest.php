<?php

class JackpotControllerTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
	}


	public function tearDown()
	{
		parent::tearDown();
	}


	/**
	 * Try request 'jackpot-it' url and test response.
	 */
	public function test_request_run_jackpot()
	{
		// var_dump('ddd');
		// die;
		$response = $this->call('GET', '/jackpot-it');	

		// $this->assertEquals('email has been sent to the winner', $response->getContent());

		
		// var_dump(\Schema::hasTable('jira_ticket'));
		$tickets = \DB::table('jira_ticket')->get();
		var_dump($tickets);
		// $this->assertEquals('email has been sent to the winner', $response->getContent());
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