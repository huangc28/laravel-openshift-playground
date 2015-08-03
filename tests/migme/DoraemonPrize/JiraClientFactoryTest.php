<?php
use App\JiraCredentials;
use App\JiraClientFactory;

class JiraClientFactoryTest extends TestCase
{
	public function test_make_jira_client()
	{
		$credentials = new JiraCredentials('bryan.ch.h', 'Huang_0216');
		$jiraClient = JiraClientFactory::make($credentials);
		$this->assertInstanceOf('Jira\JiraClient', $jiraClient);
	}
}