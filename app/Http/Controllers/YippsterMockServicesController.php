<?php namespace App\Http\Controllers;

use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client; 

class YippsterMockServicesController extends Controller {

	/**
	 * Simulate Yippster successful message "http://60.251.3.181:55555/yippster/notify"
	 *
	 * @return Response
	 */
	public function success()
	{
		// Log everything into Monolog
		
		$successfulResponse = [
			'result'  => 'SUCCESS',
			'key'	  =>  \Input::get('key'),
			'hash'    => 'dce2405c585ab4e38c92ed19ff97f813269aa5d094d9ccb02db933ef2491ec7d9455bb6d0456ef993df7fc51f6378e36ab1c946f90024a53f350d63c1fe5c8e4',
			'payphone'=> '+919289225674',
			'status'  => 'paid',
			'txnid'   => \Input::get('txnid') // this transaction id should be replaced with $_POST['txnid']
		];

		$successfulResponse_json = json_encode($successfulResponse);

		Log::info($successfulResponse_json);


		$this->fireSuccessResponse($successfulResponse);
		// redirect with success response
		return redirect('http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?result=RECEIVE');
	}

	protected function fireSuccessResponse($successfulResponse)
	{
		// use guzzle to fire post data
		$client = new Client;
		$response = $client->post('http://60.251.3.181:55555/yippster/notify', [
			'form_params' => $successfulResponse
		]);

		// write the response to monolog
		\Log::info($response->getBody()->getContents());
	}	

	/**
	 * Simulate Yippster fail message
	 */
	public function fail()
	{
		$failMessages = array(
			'result' => 'FAIL',
			'txnid'  => \Input::get('txnid'),
			'cause'  => 'repeat',
			'salt'   => '714',
			'hash'   => 'f703031c7385b80e7a625c4bef1f0105'
		);

		$url_string = http_build_query($failMessages);
		return redirect('http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?'.$url_string);
	}

	public function cancel()
	{
		$cancelMessages = array(
			'result' => 'CANCEL',
			'txnid'  => \Input::get('txnid'),
			'cause'  => 'repeat',
			'salt'   => '714',
			'hash'   => 'f703031c7385b80e7a625c4bef1f0105'
		);

		$url_string = http_build_query($cancelMessages);
		return redirect('http://localhost.projectgoth.com/sites/ajax/payment/yippster_payment_request_result?'.$url_string);
	}
}
