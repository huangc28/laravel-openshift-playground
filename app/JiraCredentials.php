<?php namespace App;

class JiraCredentials{
	public $username; 
	public $password;

	/**
	 * @param string $username | NULL
	 * @param string $password | NULL
	 */
	public function __construct($username=NULL, $password=NULL)
	{
		$this->username = $username;
		$this->password = $password;
	}
}