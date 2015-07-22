<?php namespace App;

use App\JiraLotteryBox;

class LotteryBox
{
    /**
     * Create lottery box
     *
     * @param array 
     * @return $this
     */
    public static function createBox(array $tickets)
    {
        return new JiraLotteryBox($tickets);
    }
}