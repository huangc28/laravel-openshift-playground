<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller {

	public function testRoute()
	{
		 var_dump(\App::environment());
		 var_dump(env('DB_HOST', env('OPENSHIFT_MYSQL_DB_HOST', 'localhost')));
		 var_dump(env('DB_PASSWORD', env('OPENSHIFT_MYSQL_DB_PASSWORD', '')));
	}
}
