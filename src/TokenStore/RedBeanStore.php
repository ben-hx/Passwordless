<?php

namespace Ampersand\Passwordless\TokenStore;

use Ampersand\Passwordless\TokenStore;

class RedBeanStore implements TokenStoreInterface
{

    private $config = array();


    public function __construct($config = array())
    {
        $this->config = array(
            'hash_algorithm' => 'sha256',   # Use sha256 hash for user id
            'expire' => (86400 * 365)       # Expires in one year by default
        );

        $this->config = array_merge($this->config, $config);
    }


    # Create a token
    public function createToken($userId)
    {
    }


    # Create user id hash
    public function createUserHash($userId)
    {
        return hash($this->config['hash_algorithm'],$userId);
    }


    # Get and set token in the store
    public function setToken()
    {
    }


    public function getToken()
    {
    }
}

