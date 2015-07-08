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
		// retrieve tickets from JiraTicketRepository
		// all open sprint ticket will be sync to database and be retrieved as a Eloquent Model
		// $tickets = $this->jiraTicketRepo->getOpenSprintTickets();
		$tickets = $this->jiraClient->getOpenSprintTickets();

		// Transform ticket data first
		// @todo I should write a collection for this
		// fractal transformer sucks... 
		foreach($tickets as $key => $ticket)
		{
			$tickets[$key] = $this->transformer->transform($ticket);
		}

		// store multiple tickets, automatically sync tickets
		$this->jiraTicketRepo->saveTickets($tickets);

		// sync "users" with ticket
		$this->userRepo->syncTickets($tickets);
		


		// retrieve all tickets that has not hit the jackpot "yet"
		$lotteryTickets = $this->jiraTicketRepo->getLotteryTickets();

	
		// $this->jiraRepo->saveTicketIfNotExists($tickets);
		// sync tickets with all assignee 
		// 1. store unduplicated tickets in database
		// 2. relate ticket with existed 
		// $this->jiraTicketSyncer->sync($tickets, User::all());

		// die;

		// set jackpot number.
		// @todo we should only send it once, instead of multiple times
		// 202 should become a variable
		// $this->jackpot->setJackpotNumber(202);

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
