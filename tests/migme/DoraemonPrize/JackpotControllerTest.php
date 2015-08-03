<?php

class JackpotControllerTest extends TestCase
{
	/**
	 * @todo table truncate should be moved to "JiraTicketTestCase"
	 */
	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate');
		$this->seed('UserTableSeeder');
	}

	public function tearDown()
	{
		Artisan::call('migrate:refresh');
	}

	/**
	 * Try request 'jackpot-it' url and test response.
	 *
	 * Assert that the email has been sent
	 */
	public function test_request_run_jackpot()
	{
		$response = $this->call('GET', '/jackpot-it');	

		$response_json = json_decode($response->getContent(), TRUE);

		$this->assertTrue($response_json['result']);
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