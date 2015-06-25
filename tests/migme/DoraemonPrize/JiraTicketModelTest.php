<?php

use App\JiraClientFactory;
use App\JiraTicket;
use App\Transformers\JiraTicketTransformers;
use League\Fractal\Resource\Item;

class JiraTicketModel extends TestCase
{

	/**
	 * @todo use data transformer
	 */
	public function test_store_ticket_info()
	{
		$jiraClient = $this->jiraClientProvider();
		$jiraQuery = 'project="IG" AND key="IG-202" AND sprint in openSprints()';
		$issue = $jiraClient->issues()->getFromJqlSearch($jiraQuery);

		// @todo use "Item" to transform data
		$transformer = new JiraTicketTransformers;
		$resource = $transformer->transform($issue['IG-202']);
		
		// create an JiraTicketModel
		

		// $this->assertEquals($resource['ticket_id'], "IG-202");
		// $this->assertEquals($resource['ticket_no'], '26584');
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