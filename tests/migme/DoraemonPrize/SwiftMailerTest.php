<?php
class SwiftMailerTest extends PHPUnit_Framework_TestCase
{
	public function test_swiftmail_init()
	{
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465);
		$this->assertInstanceOf('Swift_SmtpTransport', $transport);
	}

	public function test_send_email()
	{
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
		$transport
			->setUsername('bryan.ch.h@mig.me')
			->setPassword('Huang_0216');

		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance('Wonderful Subject')
			->setFrom(array('john@doe.com' => 'John Doe'))
			->setTo(array('bryan.ch.h@mig.me', 'huangchiheng@gmail.com' => 'A name'))
			->setBody('jackpot');

		$mailer->send($message);
	}
}