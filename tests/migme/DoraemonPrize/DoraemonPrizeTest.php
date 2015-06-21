<?php 

use \Mockery as m;
use App\DoraemonPrize;
use Jira\JiraClient;
class DoraemonPrizeTest extends TestCase
{
	const HOST = "http://mig-me.atlassian.net";
	const USERNAME = "bryan.ch.h";
	const PASSWORD = "Huang_0216";
	protected $candidates = array();

	protected function jira_client_provider()
	{
		$jira = new JiraClient(self::HOST);
		$jira->login(self::USERNAME, self::PASSWORD);
		return $jira;
	}

	public function setUp()
	{
		parent::setUp();
		// $this->candidates = include __DIR__.'/../src/Migme/DoraemonPrize/Candidates.php';
		$this->candidates = include app_path('Candidates.php');
	}

	/**
	 * @todo Use mockery to mock dependency.
	 */
	public function test_doraemonprize_jackpot_number()
	{
		$jira_mock = m::mock("Jira\JiraClient");
		$prize = new DoraemonPrize($jira_mock);
		$prize->setJackpotNumber(177);
		$this->assertEquals(177, $prize->getJackpotNumber());
	}

	public function test_doraemonprize_init()
	{
		$jira_mock = m::mock("Jira\JiraClient");
		$prize = new DoraemonPrize($jira);
		$this->assertInstanceOf('Migme\DoraemonPrize\DoraemonPrize', $prize);
	}

	public function test_doraemonprize_run()
	{
		$jira = $this->jira_client_provider();
		$prize = new DoraemonPrize($jira);
		$prize->setJackpotNumber(177);
		$prize->run();
	}

	public function test_get_jackpot_member_data()
	{
		$jira = $this->jira_client_provider();
		$prize = new DoraemonPrize($jira);
		$candidates = $prize->getCandidates();
		$this->assertTrue(is_array($candidates));
	}

	public function test_null_empty()
	{
		$this->assertTrue(empty(null));
		$this->assertTrue(empty([]));
	}
}