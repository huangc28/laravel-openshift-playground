<?php

use Jira\JiraClient; 
use App\JiraClientFactory;


class JiraClientTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
	}

	protected function jiraClientProvider()
	{
		$app = $this->createApplication();
		$jiraCredentials = $app->config['services']['jira'];

		$host = $jiraCredentials['host'];
		$username = $jiraCredentials['username'];
		$password = $jiraCredentials['password'];
		$jiraClient = JiraClientFactory::make($host, $username, $password);
		return $jiraClient;
	}

	public function test_jira_client_get_sprint_tasks()
	{
		$jiraQuery = 'project="IG" AND sprint in openSprints()';
		$jiraClient = $this->jiraClientProvider();
		$issues = $jiraClient->issues()->getFromJqlSearch($jiraQuery);

		// store issues in eloquent model
		var_dump($issues['IG-214']);
		die;
	}

	public function test_get_current_environment()
	{
		var_dump(App::environment());
	}
}