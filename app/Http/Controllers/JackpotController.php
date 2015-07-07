<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Jira\JiraClient;
use App\DoraemonPrize;
use App\JackpotInterface;
use App\JiraClientInterface;
use App\Transformers\JiraTicketTransformer;

class JackpotController extends Controller {

	/**
	 * @var App\Transformers\JiraTicketTransformers
	 */
	protected $transformer;

	/**
	 * @var App\JiraClientInterface
	 */
	protected $jiraClient;

	/**
	 * @var App\User
	 */
	protected $user;

	/**
	 * @param App\JackpotInterface $jackpot
	 */
	public function __construct(JiraClientInterface $jiraClient, JiraTicketTransformer $transformer)
	{
		$this->jiraClient = $jiraClient;
		$this->transformer = $transformer;
		// $this->jiraTicketSyncer = $jiraTicketSyncer;
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

		// sync the relation between "tickets" and "users"
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


		// run the jackpot.
		$winner = $jackpot->run();

		// $this->jackpot->setJackpotNumber(202);

		// what does a jackpot do? 
		// passed in list of jira tickets
		// pick the one that was matching the selected ticket number.
		// $jackpotTicket = $this->jackpot->setNominateTickets($lists)->pick(JiraTicket::find(202));
			
		// find the related jira ticket owner
			
		// $this->jackpot
		// 	->setJackpotNumber(202)
		// 	->checkFromTickets($list);

		// $winner = $this->jackpot->run();


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
