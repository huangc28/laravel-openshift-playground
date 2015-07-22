<?php

use App\JiraLotteryBox;
use App\JiraTicket;

class JiraLotteryBoxTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        DB::table('jira_ticket')->truncate();
        $this->seed('JiraTicketTableSeeder');
    }

    public function tearDown()
    {
        DB::table('jira_ticket')->truncate();
    }

    public function test_match_lottery_ticket()
    {
        // var_dump(DB::table('jira_ticket')->get());
        $jiraTickets = with( new JiraTicket )->all();
        $jiraLotteryBox = new JiraLotteryBox(
            $jiraTickets->flatten()->all()
        );
        $jiraLotteryBox->setJackpotNumber('104');
        $jackpot = $jiraLotteryBox->matchJackpot();

        var_dump($jackpot);
        die;
    }
}