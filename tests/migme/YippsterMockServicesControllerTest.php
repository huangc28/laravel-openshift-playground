<?php
use GuzzleHttp\Client; 

class YippsterMockServicesControllerTest extends TestCase
{
	protected static $sample_successful_messages = [
		'result'  => 'SUCCESS',
		'key'	  => '35215',
		'hash'    => 'dce2405c585ab4e38c92ed19ff97f813269aa5d094d9ccb02db933ef2491ec7d9455bb6d0456ef993df7fc51f6378e36ab1c946f90024a53f350d63c1fe5c8e4',
		'payphone'=> '+919289225674',
		'status'  => 'paid',
		'txnid'   => '35215' // this transaction id should be replaced with $_POST['txnid']
	];

	/**
	 * Request migbo callback url with successful messages.
	 *
	 * Tests: respond back with "APPROVED" STATUS
	 */
	public function test_request_migbo_callback_with_successful_status()
	{
		// use guzzle to fire post data
		$client = new Client;
		$response = $client->post('http://60.251.3.181:55555/yippster/notify', [
			'form_params' => self::$sample_successful_messages
		]);

		$status = $response->getBody()->getContents();
		$status_arr = json_decode($status, true);
		$this->assertEquals($status_arr['status'], 'APPROVED');
	}

	public function test_monolog()
	{
		$log = Log::getMonolog();
		var_dump(get_class($log));
	}

	public function test_yippster_request_fail_url()
	{
		$request_params = array(
			'amount' 	 => '1',
			'merchantID' => '50',
			'merchantkey'=> 'dcf889f',
			'key'        => '35233',
			'txnid'      => '35233', 
			'surl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=RECEIVE', 
			'furl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=FAILED',
			'curl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=CANCEL',
			'firstname'  => '',
			'lastname'   => '',
			'email'      => 'mucho105@brandcast.biz',
			'phone'	     => '',
			'productinfo'=> 'migme_recharge'
		);

		$response = $this->call('POST', 'yippster-mock/fail', $request_params);
		$this->assertEquals($response['txnid'], $request_params['txnid']);
	}

	public function test_yippster_request_cancel_url()
	{
		$request_params = array(
			'amount' 	 => '1',
			'merchantID' => '50',
			'merchantkey'=> 'dcf889f',
			'key'        => '35233',
			'txnid'      => '35233', 
			'surl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=RECEIVE', 
			'furl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=FAILED',
			'curl'       => 'http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=CANCEL',
			'firstname'  => '',
			'lastname'   => '',
			'email'      => 'mucho105@brandcast.biz',
			'phone'	     => '',
			'productinfo'=> 'migme_recharge'
		);

		$response = $this->call('POST', 'yippster-mock/fail', $request_params);
		var_dump($response);
		// $this->assertEquals($response['txnid'], $request_params['txnid']);
	}

	public function test_generate_hash_string()
	{
		// generate hash string from sequence
		$sample_request_params = array(
			'merchantkey' => 'dcf889f',
			'key'		  => '50',
			'txnid'	      => '35241',
			'amount'      => '20',
			'firstname'   => '',
			'lastname'    => '',
			'email'       => 'mucho105@brandcast.biz',
			// 'email'       => 'huangchiheng@gmail.com',
			'productinfo' => 'migme_recharge',
			'payphone'    => '+919289225674'
		);

		$hash_str = '';

		foreach($sample_request_params as $param)
		{
			$hash_str .= $param;
		}

		// start hashing 
		$hash = hash('sha512', $hash_str);

		
		// var_dump($hash);
		// die;

	}

	public function test_cancel_hash_matches()
	{
		$yippster_cancel_hash = "0d28e1f5beda7415d74538c66318e80f";

		$session_cancel_hash = "0d28e1f5beda7415d74538c66318e80f";
	}
}