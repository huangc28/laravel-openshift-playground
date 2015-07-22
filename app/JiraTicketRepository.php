<?php namespace App;

use App\JiraTicket;

/**
 * This repository should be an combinatory between JiraClient and JiraTicket model.
 * It is to seperate business logic from persistent data layer.
 */
class JiraTicketRepository
{

	/**
	 * @var App\JiraTicket
	 */
	protected $jiraTicket;

	public function __construct(JiraTicket $jiraTicket)
	{
		$this->jiraTicket = $jiraTicket;
	}

	/**
	 * Store tickets in Database if not existed. Duplicate ticket will be excluded.
	 *
	 * @param array $tickets
	 * @param boolean $return
	 * @return array || NULL
	 */
	public function saveTickets($tickets, $return=false)
	{	
		// var_dump($tickets);	
		// die;
		foreach($tickets as $ticketKey => $ticket) 
		{
			if(!$this->jiraTicket->checkIdExists($ticketKey))
			{
				$result = $this->jiraTicket->newInstance($ticket)->save();

				if(!$result) return $result;

				$ticketIds[] = $ticket['ticket_id'];
			}
		}

		// if result is true and return is set to true, that means user wants to retrieve tickets just saved.
		if($return)
		{
			$tickets = $this->getTicketsById($ticketIds);	

			return $tickets;
		}

		return $result;
	}

	/**
	 * Get multiple tickets by Id.
	 *
	 * @param  array
	 * @return array Instances of App\JiraTickets
	 */
	public function getTicketsById($ticketIds)
	{
		return $this->jiraTicket->whereIn('ticket_id', $ticketIds)->get();	
	}

	/**
	 * Pull out every tickets that has not been jackpotted.
	 *
	 * @param void
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getLotteryTickets()
	{
		return $this->jiraTicket->where('jackpot_hit', FALSE)->get();
	}
}
