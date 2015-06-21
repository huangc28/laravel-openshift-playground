<?php

class JackpotControllerTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
	}

	/**
	 * Try request 'jackpot-it' url and test response.
	 */
	public function test_request_run_jackpot()
	{
		$response = $this->call('GET', '/jackpot-it');
	}

	/**
	 * Uses "mandrill" as the mail driver.
	 */
	public function test_email_sending()
	{
		// var_dump(Mail::getFacadeRoot());
		Mail::send('emails.sample_email', [], function($m){
			$m->from('huangchiheng@gmail.com', 'Laravel');
			$m->to('huangchiheng@gmail.com', 'Bryan Huang')->subject('sample email');
		});
	}
}