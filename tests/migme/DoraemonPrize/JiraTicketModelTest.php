<?php

use App\JiraClientFactory;
use App\JiraTicket;
use App\Transformers\JiraTicketTransformers;
use League\Fractal\Resource\Item;

class JiraTicketModel extends TestCase
{

	/**
	 * Test data has been stored in JiraTicket model.
	 *
	 * Tests:
	 * 		1. test data has been stored in model.
	 */
	public function test_store_ticket_info()
	{
		$jiraClient = $this->jiraClientProvider();
		$jiraQuery = 'project="IG" AND key="IG-202" AND sprint in openSprints()';
		$issue = $jiraClient->issues()->getFromJqlSearch($jiraQuery);

		// @todo use "Item" to transform data
		$transformer = new JiraTicketTransformers;
		$resource = $transformer->transform($issue['IG-202']);

		$jiraTicket = new JiraTicket;
		$jiraTicket->fill($resource);
		$jiraTicket->save();
		
		$jiraTicket = JiraTicket::find(1);

		// test 1
		$this->assertEquals($jiraTicket->ticket_id, $resource['ticket_id']);
		$this->assertEquals($jiraTicket->ticket_no, $resource['ticket_no']);
		$this->assertEquals($jiraTicket->jackpot_hit, false);
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
}