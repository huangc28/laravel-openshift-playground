<?php 

use App\LotteryBox;

/**
 * Create a lotterybox.
 */
class LotteryBoxTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_lottery_box_create_new_box()
    {
        $box = LotteryBox::createBox($tickets);
        
        $this->assertInstanceOf('App\JiraLotteryBox', $box);
    }   
}