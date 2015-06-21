<?php namespace App;

use Jira\JiraClient;
class DoraemonPrize
{
	protected $jackpot_number;
	protected $jira_client;
	protected $candidates = array();

	/**
	 * Construct. 
	 *
	 * @param Jira\JiraClient
	 */
	public function __construct(JiraClient $jira_client)
	{
		$this->jira_client = $jira_client;
		$this->candidates = include __DIR__."/Candidates.php";
	}

	/**
	 * Set jackpot number.
	 *
	 * @param int 
	 */
	public function setJackpotNumber($jackpot_number)
	{
		$this->jackpot_number = $jackpot_number;
	}

	/**
	 * Get jackpot number.
	 *
	 * @return int $jackpot_number
	 */
	public function getJackpotNumber()
	{
		return $this->jackpot_number;
	}	

	/**
	 * Get jackpot member from jira client.
	 *
	 * @return array || NULL
	 */
	public function getCandidates()
	{
		return $this->candidates;
	}	

	/**
	 * Find member from IG-team which gets the jackpot.
	 *
	 * @return array $jackpot
	 */
	public function run()
	{
		// retrieve all issues confined within:
		// 1. project: IG
		// 2. sprint: openSprint()
		$jql_query = 'project="IG" AND sprint in openSprints()';
		$issues = $this->jira_client->issues()->getFromJqlSearch($jql_query);

		// fetch 
		// 1. "key" 
		// 2. "assignee"
		$jackpot = $this->matchJackpot($issues);	

		// retrieve email of the lottery winner
		$jackpot['email'] = array_key_exists($jackpot['assignee'], $this->candidates) ? $this->candidates[$jackpot['assignee']]['email'] : NULL;

		return $jackpot;

	}

	/**
	 * Try match jackpot 
	 *
	 * @todo efficiency problem
	 * @param Jira\Remote\RemoteIssue
	 * @return array || NULL
	 */
	protected function matchJackpot($issues)
	{
		$jackpot = array();
		foreach($issues as $id => $issue)
		{
			$key = preg_replace('/[^\d]/' ,"", $issue->key);
			if((int)$key == $this->getJackpotNumber())
			return array(
					"assignee" => $issue->assignee,
					"key"	   => $issue->key
				);
		}

		return NULL;
	}
}