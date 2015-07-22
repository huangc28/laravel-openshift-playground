<?php

// use App\JiraClientFactory;
use Jira\JiraClient;
use App\User;
use App\JiraTicket;
use App\Transformers\JiraTicketTransformers;
use League\Fractal\Resource\Item;

class JiraTicketModel extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        // truncate jira_ticket table, seed again
        DB::table('jira_ticket')->truncate();
        $this->seed();
    }

    /**
     * Test data has been stored in JiraTicket model.
     *
     * Tests:
     *      1. test data has been stored in model.
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

    public function test_get_multiple_jira_tickets_by_ids()
    {
        $ticketIds = [
            '100',
            '102',
            '104'
        ];

        $jiraTicket = new JiraTicket;
        $jiraTickets = $jiraTicket->whereIn('ticket_id', $ticketIds)->get();    
        $this->assertEquals($jiraTickets->count(), count($ticketIds));

        foreach($jiraTickets as $jiraTicket)
        {
            $this->assertTrue(in_array($jiraTicket->ticket_id, $ticketIds));
        }
    }

    /**
     * Test user relate multiple tickets. User and ticket relationship is one to many. 
     */
    public function test_user_relate_multiple_tickets()
    {
        $user = User::find(1);

        // create new  JiraTicket
        $ticket_1 = new JiraTicket([
            'ticket_id'   => '111',
            'ticket_no'   => '10011',
            'assignee_jira_id'=> '',
            'jackpot_hit' => false
        ]);

        // create new  JiraTicket
        $ticket_2 = new JiraTicket([
            'ticket_id'   => '112',
            'ticket_no'   => '10012',
            'assignee_jira_id'=> '',
            'jackpot_hit' => false
        ]);        

        // establish the relationship
        $user->jiraTicket()->save($ticket_1);
        $user->jiraTicket()->save($ticket_2);

        // test the user has multiple data.
        $tickets = $user->jiraTicket;

        // makesure ticket_no exists
        $this->assertEquals($ticket_1->ticket_id, $tickets[1]->ticket_id);
        $this->assertEquals($ticket_2->ticket_id, $tickets[2]->ticket_id);
    }   

    /**
     *
     *
     *
     */
    public function test_get_jira_ticket_owner()
    {

    }

    protected function jiraClientProvider()
    {
        $app = $this->createApplication();
        $jiraCredentials = $app->config['services']['jira'];
        $host = $jiraCredentials['host'];
        $username = $jiraCredentials['username'];
        $password = $jiraCredentials['password'];
        $jiraClient = new JiraClient($host);
        $jiraClient->login($username, $password);
        // $jiraClient = JiraClientFactory::make($host, $username, $password);
        return $jiraClient;
    }

    public function test_get_lottery_tickets()
    {
        $jiraTicket = new JiraTicket;
        $jiraTickets = $jiraTicket->getLotteryTickets();
        
        foreach($jiraTickets as $ticket)
        {
            $this->assertFalse( !!$ticket->jackpot_hit );
        }
    }
}