<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Jira\JiraClient;
use App\DoraemonPrize;
use App\JackpotInterface;
use App\JiraClientInterface;
use App\Transformers\JiraTicketTransformer;
use App\JiraTicketRepository;
use App\JiraUserRepository;
use App\JiraLotteryBox;

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
	 * @var App\JiraTicketRepository
	 */
	protected $jiraRepo;

	/**
	 * @var App\JiraUserRepository
	 */
	protected $jiraUserRepo;

	/**
	 * @param App\JackpotInterface $jackpot
	 */
	public function __construct(
									JiraClientInterface $jiraClient, 
									JiraTicketTransformer $transformer, 
									JiraTicketRepository $jiraRepo,
									JiraUserRepository $jiraUserRepo
								)
	{
		$this->jiraClient   = $jiraClient;
		$this->transformer  = $transformer;
		$this->jiraRepo     = $jiraRepo;
		$this->jiraUserRepo = $jiraUserRepo; 
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

		// store multiple tickets.
		$tickets = $this->jiraRepo->saveTickets($tickets, TRUE);

		// sync the relation between "tickets" and "users"
		$this->jiraUserRepo->syncTickets($tickets);

		$lotteryTickets = $this->jiraRepo->getLotteryTickets()->flatten()->all();

		$lotteryBox = new JiraLotteryBox(
			$lotteryTickets
		);

		// draw one ticket out
		$jackpotTicket = $lotteryBox
							->setJackpotNumber(\Config::get('jiraJackpot')['jackpotNumber'])
							->matchJackpot();

		var_dump($jackpotTicket);
		die;
		if(!is_null($jackpotTicket))
		{
			$winner = $jackpotTicket->user;

			var_dump($winner);
			die;
			\Mail::send('emails.migme_jackpot', [], function($message) use ($winner){
				$message->from('bryan.ch.h@mig.me', 'Laravel');
				$message->to($winner->email, $winner->mig_id)->subject('sample email');
			});
		}


		// if winner is not "empty", we send out the email.
		// if(!is_null($winner))
		// {
		// 	$to = 'bryan.ch.h@mig.me';

		// 	\Mail::send('emails.migme_jackpot', [], function($message) use ($winner){
		// 		$message->from('bryan.ch.h@mig.me', 'Laravel');
		// 		$message->to($winner['email'], $winner['assignee'])->subject('sample email');
		// 	});
		// 	// @todo log 
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
