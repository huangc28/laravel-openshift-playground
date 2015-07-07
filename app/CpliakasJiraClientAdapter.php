<?php namespace App;

use App\JiraClientInterface;
use Jira\JiraClient;
class CpliakasJiraClientAdapter implements JiraClientInterface
{
	const GET_OPEN_SPRINT_TICKETS = 'project="IG" AND sprint in openSprints()';

	/**
	 * @var Jira\JiraClient
	 */
	protected $jiraClient;

	public function __construct(JiraClient $jiraClient)
	{
		$this->jiraClient = $jiraClient;
	}

	public function getOpenSprintTickets()
	{
		$issues = $this->jiraClient->issues()->getFromJqlSearch(self::GET_OPEN_SPRINT_TICKETS);
		return $issues;		
	}
}