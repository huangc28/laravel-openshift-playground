<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Jira\JiraClient;
use App\DoraemonPrize;

class JackpotController extends Controller {

	const HOST = "http://mig-me.atlassian.net";
	const USERNAME = "bryan.ch.h";
	const PASSWORD = "Huang_0216";

	public function __construct()
	{

	}

	public function getJackpot()
	{

		$jiraClientProvider = $this->jiraClientProvider();

		$jackpot = new DoraemonPrize($jiraClientProvider);

		// set jackpot number.
		$jackpot->setJackpotNumber(202);

		// run the jackpot.
		$winner = $jackpot->run();

		// if winner is not "empty", we send out the email.
		if(!is_null($winner))
		{
			// send jackpot email
			$result = \Mail::send('email.migme_jackpot', [], function($message){

				// from Achi
				// to whoever got jackpot ticket
				$message->from('achi.c@mig.me', 'migme jackpot price');
				$message->to($winner['email'], $winner['assignee']);
			});

			var_dump($result);
			die;
		}

		// if jackpot returns a winner, then we send out an email
	}

	protected function jiraClientProvider()
	{
		$jira = new JiraClient(self::HOST);
		$jira->login(self::USERNAME, self::PASSWORD);
		return $jira;
	}

	/**
	 * Retrieve email of the jackpot candidate
	 *
	 * @param string $candidate
	 */
	protected function getJackpotEmail($candidate)
	{
		if(array_key_exists($candidate, $this->candidates))
		{
			return $this->candidates[$candidate]['email'];
		}
		else
		{
			throw new \Exception("Candidate does not exist");
		}	
	}
}
