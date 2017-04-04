<?php

namespace Omnimail\Tests;

use Omnimail\Exception\Exception;
use Omnimail\Email;
use Omnimail\Omnimail;
use Omnimail\Tests\BaseTestClass;

class SwiftmailerTest extends BaseTestClass {
  public function testSend() {
    $sender = Omnimail::create('Swiftmailer');

    $email = (new Email())
      ->addTo('from@example.com')
      ->setFrom('to@mcnaughty.com')
      ->setSubject('Hello, world!')
      ->setTextBody('Hello World! How are you?');

    $sender->send($email);
  }
}
