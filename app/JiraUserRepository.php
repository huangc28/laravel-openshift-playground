<?php namespace App;

use DB;
use App\User;

class JiraUserRepository 
{
    /**
     * @var App\User
     */
    protected $user;

    /**
     * @param App\User
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Make one to many relation for user/tickets.
     *
     * @param array of App\Ticket
     */
    public function syncTickets($tickets)
    {
        $users = $this->getAll();

        foreach($users as $user)
        {
            // filter out tickets that only belongs to the current user.
            $filteredTickets = $tickets->filter(function($ticket) use($user) {
                if($ticket->assignee == $user->name) return $ticket;            
            });

            $user->jiraTicket()->saveMany($filteredTickets->flatten()->all());
        }
    }



    /**
     * Get all users
     *
     * @return 
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * Get all mig ids. Stored in array
     *
     * @return array 
     */
    public function getAllMigIds()
    {
        return $this->user->lists('mig_id');
    }

    /**
     * Check if jira user exists.
     *
     * @param string $user
     * @return boolean
     */
    public function hasJiraUser($user)
    {
        return $this->user->hasJiraUser($user);
    }

    /**
     * Get user by Jira id.
     *
     * @param string $jira
     * @return App\User
     */
    public function getByJiraId($jiraId)
    {
        return $this->user->getByJiraId($jiraId);
    }
}