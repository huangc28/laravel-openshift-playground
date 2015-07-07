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
		$this->jiraTicket = $jiraTicket
	}

	/**
	 * Store tickets in Database if not existed. Duplicate ticket will be excluded.
	 *
	 * @param array $tickets
	 * @return boolean
	 */
	public function saveTickets($tickets)
	{	
		foreach($tickets as $ticketKey => $ticket) 
		{
			if(!$this->jiraTicket->checkIdExists($ticketKey))
			{
				$result = $this->jiraTicket->newInstance($ticket)->save();

				if(!$result) return $result;
			}
		}

		return $result;
	}
}
