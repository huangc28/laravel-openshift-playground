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

	public function getJackpot()
	{

		var_dump('dddd');
		// $jiraClientProvider = $this->jiraClientProvider();

		// $jackpot = new DoraemonPrize($jiraClientProvider);

		// // set jackpot number.
		// $jackpot->setJackpotNumber(202);

		// // run the jackpot.
		// $winner = $jackpot->run();

		// // if winner is not "empty", we send out the email.
		// if(!is_null($winner))
		// {
		// 	$to = 'bryan.ch.h@mig.me';

		// 	\Mail::send('emails.sample_email', [], function($message) use ($winner){
		// 		$message->from('bryan.ch.h@mig.me', 'Laravel');
		// 		$message->to($winner['email'], $winner['assignee'])->subject('sample email');
		// 	});
		// }
		// else
		// {
		// 	return response('no winner at the moment', 200);
		// }

		// return response('email has been sent to the winner', 200);

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
