<?php namespace App;

class JiraTicketSyncer implements JiraTicketSynerInterface
{

	/**
	 * Sync between jira ticket and users.
	 *
	 * @param array $tickets
	 * @param User $user
	 */
	public function sync($tickets, $user) 
	{
		foreach($tickets as $ticket)
		{
			$this->user->ticket
		}
	}	
}