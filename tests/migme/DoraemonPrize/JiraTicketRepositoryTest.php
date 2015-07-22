<?php

use Mockery as m;
use App\JiraTicketRepository;
use App\JiraTicket;

class JiraTicketRepositoryTest extends TestCase
{

	public function setUp()
	{
		parent::setUp();
		$this->seed();
	}

    public function tearDown()
    {
        m::close();
    }

    /**
     * Test get jira tickets by id.
     *
     * Tests:
     *  1. Retrieve jira tickets by ids.
     */
	public function test_get_jira_tickets_by_ids()
	{
        // mock JiraTicket model
        $jiraTicket = m::mock('App\JiraTicket');
        $modelQueryBuilder = m::mock('Illuminate\Database\Eloquent\Builder');
        $queryResult = new stdClass;
        $queryResult->ticket_id = '100';
        $jiraRepo = new JiraTicketRepository($jiraTicket);
        $modelQueryBuilder
            ->shouldReceive('get')
            ->once()
            ->andReturn($queryResult);
        $jiraTicket
            ->shouldReceive('whereIn')
            ->once()
            ->with('ticket_id', ['100', '102', '104'])
            ->andReturn($modelQueryBuilder);
        $result = $jiraRepo->getTicketsById(['100', '102', '104']);
        $this->assertEquals('100', $queryResult->ticket_id);
	}
	
    public function test_sample_class_mockery()
    {
        $mock_b = m::mock('ClassB[sayHello]');
        $a = new ClassA($mock_b);
        $mock_b
            ->shouldReceive('sayHello')
            ->once()
            ->andReturn('sad');
        $result = $a->sayHello();
        // $this->assertEquals('sad', $result);
    }
}

class ClassA
{
    protected $b;
    public function __construct($b)
    {
        $this->b = $b;
    } 
    public function sayHello()
    {
        return $this->b->sayHello();
    }
}

class ClassB
{
    public function sayHello()
    {
        return "hello";
    }
}