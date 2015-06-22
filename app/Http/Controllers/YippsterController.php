<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class YippsterController extends Controller {


	/**
	 * Initiating payment request.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$request->session()->put('txnid', time());
		$request->session()->put('surl', 'http://'.$_SERVER["HTTP_HOST"].'/demo/receive.php');
		$request->session()->put('furl','http://'.$_SERVER["HTTP_HOST"].'/demo/fail.php');
		$request->session()->put('curl','http://'.$_SERVER["HTTP_HOST"].'/demo/cancel.php');
		$request->session()->put('firstname','');
		$request->session()->put('lastname', '');
		$request->session()->put('email', '');
		$request->session()->put('phone', '');
		$request->session()->put('productinfo', 'Demo');
		$request->session()->put('amount', '2');
		$request->session()->put('merchantID', '34');
		$request->session()->put('merchantkey', 'dm345345');

		return view("Yippster.index");

	}

	public function ext(Request $request)
	{
		$request->session()->put('key', substr(md5(rand()), 0, 7));

		$key   = $request->session()->get("key");
		$txnid = $request->session()->get("txnid");
		$surl  = $request->session()->get("surl");
        $furl  = $request->session()->get("furl");
        $curl  = $request->session()->get("curl");
        $firstname = $request->session()->get("firstname");
        $lastname  = $request->session()->get("lastname");
        $email = $request->session()->get("email");
        $phone = $request->session()->get("phone");
        $productinfo = $request->session()->get("productinfo");
        $amount = $request->session()->get("amount");
        $merchantID = $request->session()->get("merchantID");
        $merchantkey= $request->session()->get('merchantkey');
 		$hash = hash('md5',($amount.$merchantID.$merchantkey.$key.$txnid.$surl.$furl.$curl.$firstname.$lastname.$email.$phone.$productinfo));		
 		

 		return view("Yippster.ext", compact(
 			'key',
 			'txnid',
 			'surl',
 			'furl',
 			'curl',
 			'firstname',
 			'lastname',
 			'email',
 			'phone',
 			'productinfo',
 			'amount',
 			'merchantID',
 			'merchantkey',
 			'hash'
 		));
	}
}
