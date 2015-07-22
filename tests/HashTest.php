<?php

class HashTest extends TestCase
{
	protected static $hash_sequence = array(
			'success' => array(
				'key',
				'merchantKey',
				'txnid',
				'amount',
				'firstname',
				'lastname',
				'email',
				'productinfo',
				'payphone'
			),
			'fail' => array(
				'furl',
				'merchantID',
				'amount',
				'txnid'
			),
			'cancel' => array(
				'txnid',
				'amount',
				'productinfo'
			)
		);

	public function test_hash_sequence()
	{	
		
	}

	private function generate_hash()
	{

	}
}