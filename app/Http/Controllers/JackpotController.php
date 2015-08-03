<?php namespace App\Http\Controllers;

use Mail;
use Input;
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

class JackpotController extends Controller 
{

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

		$lotteryTickets = $this->jiraRepo
									->getLotteryTickets()
									->flatten()
									->all();

		// extract the dependecy
		$lotteryBox = new JiraLotteryBox(
			$lotteryTickets
		);

		$jackpotNumber = (Input::has('jackpotNum')) ? Input::get('jackpotNum') : \Config::get('jiraJackpot')['jackpotNumber'];

		// draw one ticket out
		$jackpotTicket = $lotteryBox
							->setJackpotNumber($jackpotNumber)
							->matchJackpot();

		// if jackpot ticket is found, we found a related user.
		if(!is_null($jackpotTicket))
		{
			$winner = $jackpotTicket->user;

			try
			{
				$result = \Mail::send('emails.migme_jackpot', [], function($message) use ($winner){
					$message->from('achi.c@mig.me', 'Achi Chen');
					$message->to($winner->email, $winner->mig_id)->subject('Congratulation! you just hit the jira jackpot');
				});

				return $this->sendOkResponse($result, $winner->name, $winner->email);
			}
			catch(\Exception $e)
			{
				return $this->sendFailResponse($e->getMessage());
			}

		}
		else
		{
			return $this->sendFailResponse('Jira ticket not found');
		}
	}

	/**
	 * Send ok response.
	 * 
	 * [  
	 *    'result'   => 1,
	 *    'name' => 'bryan.ch.h', // name
	 *    'email'    => 'bryan.ch.h@mig.me'
	 * ]
	 *
	 * @param int $result
	 * @param string $name
	 * @param string $email
	 */
	protected function sendOkResponse($name, $email)
	{
		// compose parameters into array, convert it into json
		$result_arr = [
			'result' => true,
			'name'   => $name,
			'email'  => $email
		];

		// return a response 
		return response()->json($result_arr);
	}

	/**
	 * Send fail response
	 *
	 * [
	 *   'result' => 'fail'
	 *   'reason' => ...
	 * ]
	 *
	 * @param string $message
	 * @return response
	 */
	protected function sendFailResponse($message)
	{
		$result_arr = [
			'result' => false,
			'reason' => $message
		];

		return response()->json($result_arr);
	}
}
