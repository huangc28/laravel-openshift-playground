<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jira\JiraClient;
use App\DoraemonPrize;
use App\JackpotInterface;

class JackpotController extends Controller 
{

	/**
	 * @var App\JackpotInterface
	 */
	protected $jackpot;

	/**
	 * @param App\JackpotInterface $jackpot
	 */
	public function __construct(JackpotInterface $jackpot)
	{
		$this->jackpot = $jackpot;
	}

	public function getJackpot()
	{
		// set jackpot number.
		// @todo we should only send it once, instead of multiple times
		// 202 should become a variable
		$this->jackpot->setJackpotNumber(202);

		// run the jackpot.
		$winner = $this->jackpot->run();

		// if winner is not "empty", we send out the email.
		if(!is_null($winner))
		{
			$to = 'bryan.ch.h@mig.me';

			\Mail::send('emails.migme_jackpot', [], function($message) use ($winner){
				$message->from('bryan.ch.h@mig.me', 'Laravel');
				$message->to($winner['email'], $winner['assignee'])->subject('sample email');
			});
			// @todo log 
		}
		else
		{
			return response('no winner at the moment', 200);
		}

		return response('email has been sent to the winner', 200);
	}
}
