<?php

require 'vendor/autoload.php';

use \Ampersand\Passwordless\Passwordless;

class PasswordlessTest extends \PHPUnit_Framework_TestCase
{

    public function testIfPasswordlessCanBeInitialized()
    {
        $passwordless = new Passwordless(array());
        $this->assertTrue( $passwordless instanceof Passwordless );
    }


    public function testIfDeliveryCanBeAdded()
    {
        $passwordless = new Passwordless(array());
        $this->assertTrue( $passwordless->addDelivery(new \Ampersand\Passwordless\TokenDelivery\SwiftMailer) );
    }

}
