<?php

class MandrillTest extends TestCase
{
    public function test_mandrill_send_email()
    {
        $result = \Mail::send('emails.migme_jackpot', [], function($message){
            $message->to('huangchiheng@gmail.com', 'Bryan Huang')->subject('sample email');
        });

        var_dump($result);
    }
}