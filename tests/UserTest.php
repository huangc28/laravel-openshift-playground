<?php
use App\User;
class UserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->seed('UserTableSeeder');
    }

    public function tearDown()
    {
        // parent::tearDown();
        DB::table('users')->truncate();
    }

    /**
     * Test retrieve "mig_id" for all user.
     */
    public function test_get_all_mig_ids()
    {
        $user = new User;
        $migIds = $user->lists('mig_id');

        $this->assertContains('achi.c', $migIds);
        $this->assertContains('andre.l', $migIds);
        $this->assertContains('bryan.ch.h', $migIds);
        $this->assertContains('damiano.t', $migIds);
    }

    public function test_jira_user_exists()
    {
        $user = new User;
        $result = $user->hasJiraUser('bryan.ch.h');
        $this->assertTrue($result);
    }
}