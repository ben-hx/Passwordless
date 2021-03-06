<?php

require 'vendor/autoload.php';

use \Ampersand\Passwordless\Passwordless;

class PasswordlessTest extends \PHPUnit_Framework_TestCase
{

    protected $passwordless;

    protected $storeMock;


    public function setUp()
    {

        $this->tokenStoreMock = $this->getMock('\Ampersand\Passwordless\TokenStore\RedBeanStore');
        $this->sessionStoreMock = $this->getMock('\Ampersand\Passwordless\SessionStore\RedBeanStore');

        $this->tokenStoreMock->expects($this->any())
            ->method('createUserHash')
            ->with('test@test.com')
            ->will($this->returnValue(hash('sha256','test@test.com')));

        $this->tokenStoreMock->expects($this->any())
            ->method('createToken')
            ->will($this->returnValue(hash('sha256',mt_rand(0,1000))));

        $this->passwordless = new Passwordless($this->tokenStoreMock, $this->sessionStoreMock, array());
    }


    /*
     *
     */
    public function testIfPasswordlessCanBeInitialized()
    {
        $passwordless = new Passwordless($this->tokenStoreMock, $this->sessionStoreMock, array());
        $this->assertTrue( $passwordless instanceof Passwordless );
    }


    /*
     * @depends testIfPasswordlessCanBeInitialized
     */
    public function testIfDeliveryCanBeAdded()
    {
        $this->assertTrue( $this->passwordless->addDelivery(
            $this->getMock('\Ampersand\Passwordless\TokenDelivery\SwiftMailer')
        ));
    }


    /*
     * @depends testIfPasswordlessCanBeInitialized
     */
    public function testIfTokenCanBeRequested()
    {
        $token = $this->passwordless->requestToken('test@test.com');
        $this->assertNotEmpty($token);
    }

}
