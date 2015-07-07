<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class YippsterMockServicesController extends Controller {

	/**
	 * Receive successful messages from "http://60.251.3.181:55555/yippster/notify"
	 *
	 * @return Response
	 */
	public function success()
	{
		var_dump('Yippster mock services');
		// var_dump(\Input::get());	
	}
}
