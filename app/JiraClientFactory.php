<?php namespace App;

use Jira\JiraClient;
use Log;

class JiraClientFactory
{
	/**
	 * Create instance of Jira 
	 * 
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 */
	public static function make($host, $username, $password)
	{
		try
		{
			$jira = new JiraClient($host);
			$jira->login($username, $password);

			Log::info("=== Jira Client has been made successfully ===");
		}
		catch(\Exception $e)
		{
			// Log error message
			Log::info(printf("====".$e->getMessage())."====");
		}

		return $jira; 
	}
}