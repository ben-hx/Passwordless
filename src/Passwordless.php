<?php

namespace Ampersand\Passwordless;

class Passwordless
{

    private $tokenStore;
    private $sessionStore;

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
    public function __construct($tokenStore, $sessionStore, $config = array())
    {
        $this->tokenStore = $tokenStore;
        $this->sessionStore = $sessionStore;
    }


    public function addDelivery($delivery)
    {
        if( is_object($delivery) ){
            $this->tokenDelivery[] = $delivery;
            return true;
        }

        return false;
    }


    /*
     * Request a token
     *
     * @param $userId The users e-mail address is also the user id
     */
    public function requestToken($userId)
    {
        $token = $this->tokenStore->createToken($userId);

        if (!empty( $this->tokenDelivery ) && count($this->tokenDelivery)>0 ) {
            foreach($this->tokenDelivery as $key => $delivery ){
                $delivery->deliver( $token, $this->getUserHash($userId), $userId );
            }
        }

        return $token;
    }


    public function getUserTokens($userId)
    {
        $token = $this->tokenStore->getUserTokens($userId);
        return $token;
    }


    public function invalidateToken($tokenId)
    {
        $token = $this->tokenStore->invalidateToken($tokenId);
        return $token;
    }


    public function getUserHash($userId)
    {
        $hash = $this->tokenStore->createUserHash($userId);
        return $hash;
    }


    public function logout($sessionId)
    {
        return $this->sessionStore->destroySession($sessionId);
    }
}
