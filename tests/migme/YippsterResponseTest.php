<?php

class YippsterResponseTest extends TestCase
{
	public function test_update_yippster_record()
	{
		$yippster_response = array(
			'txnid'  => '35214',
			'status' => 'received'
		);

		$yippster_response_json = json_encode($yippster_response);

		var_dump($yippster_response_json);
		die;
		$yippster_endpoint = curl_init();
		curl_setopt($yippster_endpoint, CURLOPT_URL, 'http://yippster.com/smspay/testent.php');
		curl_setopt($yippster_endpoint, CURLOPT_POST, TRUE); 
        curl_setopt($yippster_endpoint, CURLOPT_POSTFIELDS,$yippster_response_json); 
        $response = curl_exec($yippster_endpoint);
        var_dump($response);
		curl_close($yippster_endpoint);        
	}
}