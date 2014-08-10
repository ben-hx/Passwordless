<?php

namespace Ampersand\Passwordless;

class Passwordless
{

    private $tokenStore;

    private $tokenDelivery = array();

    /**
     * Constructor accepting configuration options
     *
     * @param $config
     *
     * Usage:
     *      $passwordless = new Passwordless(
     *          new \Ampersand\Passwordless\TokenStore\RedBean($redbeanStore, array(
     *              'expire' => '365'
     *          ), array()
     *      );
     *
     *      $passwordless->addDelivery(new \Ampersand\Passwordless\TokenDelivery\SwiftMailer(array(
     *          'mailFrom' => 'token@mycompany.com'
     *      ));
     */
    public function __construct($tokenStore, $config = array())
    {
        $this->tokenStore = $tokenStore;
    }


    public function addDelivery($delivery)
    {
        return true;
    }


    public function requestToken($userId)
    {
        $token = $this->tokenStore->createToken($userId);
        return $token;
    }


    public function getToken($userId)
    {
        $token = $this->tokenStore->getToken($userId);
        return $token;
    }


    public function getUserHash($userId)
    {
        $hash = $this->tokenStore->createUserHash($userId);
        return $hash;
    }

}
