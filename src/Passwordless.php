<?php

namespace Ampersand\Passwordless;

class Passwordless
{

    /**
     * Constructor accepting configuration options
     *
     * @param $config
     *
     * Usage:
     *      $passwordless = new Passwordless(
     *          'tokenDelivery' =>
     *          ),
     *          'tokenStore' => new \Ampersand\Passwordless\TokenStore\RedBean(array(
     *                  'expire' => '365'
     *              )
     *          )
     *      );
     *
     *      $passwordless->addDelivery(new \Ampersand\Passwordless\TokenDelivery\SwiftMailer(array(
     *          'mailFrom' => 'token@mycompany.com'
     *      ));
     */
    public function __construct($config)
    {

    }


    public function addDelivery($delivery)
    {
        return true;
    }


    public function requestToken()
    {
        return true;
    }

}
