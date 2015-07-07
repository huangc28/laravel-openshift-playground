<?php 

use Jira\JiraClient;
use League\Fractal\Resource\Collection;

class JiraTicketTransformerTest extends TestCase
{
	const HOST = "http://mig-me.atlassian.net";
	const USERNAME = "bryan.ch.h";
	const PASSWORD = "Huang_0216";

	// retrieve ticket data from jira api
	protected function jiraClientProvider()
	{
		$jira = new JiraClient(self::HOST);
		$jira->login(self::USERNAME, self::PASSWORD);
		return $jira;
	}

	protected function retrieveOpenTickets()
	{
		$jiraClient = $this->jiraClientProvider();
		$jql_query = 'project="IG" AND sprint in openSprints()';
		$issues = $jiraClient->issues()->getFromJqlSearch($jql_query);
		return $issues;
	}

	public function test_transform_tickets()
	{
		$issues = $this->retrieveOpenTickets();


		$resources = new Collection($issues, function($issue){
			return [
				'ticket_id'	=>	$issue->key,
				'ticket_no'	=>	$issue->id
			];
		});


		// foreach($resources as $resource)
		// {
		// 	var_dump($resource);
		// }
		var_dump($resources);
		die;

		// $jira = $this->jiraClientProvider();
	}
}