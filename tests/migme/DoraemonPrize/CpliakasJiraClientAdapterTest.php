<?php

use Jira\JiraClient;
use App\JiraClientFactory;
use App\CpliakasJiraClientAdapter;

class CpliakasJiraClientAdapterTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
	}

	protected function jiraClientProvider()
	{
		$credentials = $this->app->config['services']['jira'];
		$username = $credentials['username'];
		$password = $credentials['password'];
		$jira = new JiraClient($credentials['host']);
		$jira->login($username, $password);
		return $jira;
	}

	public function test_get_current_sprint_tickets()
	{
		$jiraClient = $this->jiraClientProvider();
		$jiraClientAdapter = new CpliakasJiraClientAdapter($jiraClient);
		$openSprintTickets = $jiraClientAdapter->getOpenSprintTickets();
		$this->assertNotEmpty($openSprintTickets);
		// var_dump($openSprintTickets);
	}
}