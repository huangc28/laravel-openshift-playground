<?php

class SmtpMailTest extends TestCase
{
    public function test_smtp_send_email()
    {
        $result = \Mail::send('emails.migme_jackpot', [], function($message){
            $message->from('bryan.ch.h@mig.me', 'Bryan Huang');
            $message->to('huangchiheng@gmail.com', 'Bryan Huang')->subject('from google smtp');
        });

        var_dump($result);
    }
}
