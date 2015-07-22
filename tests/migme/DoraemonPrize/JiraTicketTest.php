<?php

use App\JiraTicket;
class JiraTicketTest extends TestCase
{
	public function setUp()
	{
		// var_dump($_ENV);
		// die;
		parent::setUp();
		$this->seed();
	}

	public function test_get_ticket_by_jira_id()
	{
		$ticket = new JiraTicket;
		$ticket = $ticket->findByTicketId('IG-202');
		$this->assertEquals($ticket->ticket_id, 'IG-202');
	}

	public function test_check_ticket_exists()
	{
		$ticket = new JiraTicket;
		$existence = $ticket->checkIdExists('IG-202');
		$this->assertTrue($existence);
	}

	public function test_get_lottery_tickets()
	{
		$ticket = new JiraTicket;
		$lotteryTickets = $ticket->getLotteryTickets();
		$this->assertNotTrue($lotteryTickets[0]->jackpot_hit);
		
	}

	public function test_get_tickets_by_id()
	{
		$ticketIds = array(
			'100', 
			'102',
			'104'
		);
		$ticket = new JiraTicket;
		$tickets = $ticket->whereIn('ticket_id', $ticketIds);
		var_dump($tickets);
	}
}