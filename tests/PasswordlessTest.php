<?php

require 'vendor/autoload.php';

use \Ampersand\Passwordless\Passwordless;

class PasswordlessTest extends \PHPUnit_Framework_TestCase
{

    protected $passwordless;

    protected $storeMock;


    public function setUp()
    {

        $this->storeMock = $this->getMock('\Ampersand\Passwordless\TokenStore\RedBeanStore');

        $this->storeMock->expects($this->any())
            ->method('createUserHash')
            ->with('test@test.com')
            ->will($this->returnValue(hash('sha256','test@test.com')));

        $this->passwordless = new Passwordless($this->storeMock, array());
    }


    /*
     *
     */
    public function testIfPasswordlessCanBeInitialized()
    {
        $passwordless = new Passwordless(array());
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
    public function testIfHashCanBeCalculated()
    {
        $this->assertNotEmpty( $this->passwordless->getUserHash('test@test.com') );
        $this->assertEquals('f660ab912ec121d1b1e928a0bb4bc61b15f5ad44d5efdc4e1c92a25e99b8e44a', $this->passwordless->getUserHash('test@test.com') );
    }

}
