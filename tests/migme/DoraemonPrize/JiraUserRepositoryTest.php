<?php

use App\JiraUserRepository; 
use App\User;

class JiraUserRepositoryTest extends TestCase
{
	// protected 

	public function setUp()
	{
		parent::setUp(); 
	}

	public function test_jira_user_repository_sync_tickets()
	{
		$userRepo = new JiraUserRepository(new User);

		$userRepo->sync($tickets);
	}
}