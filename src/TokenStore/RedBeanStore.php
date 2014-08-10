<?php

namespace Ampersand\Passwordless\TokenStore;

use Ampersand\Passwordless\TokenStore;
use R;


class RedBeanStore extends AbstractTokenStore
{

    private $config = array();


    public function __construct($store = null, $config = array())
    {
        $this->config = array(
            'hash_algorithm' => 'sha256',   # Use sha256 hash for user id
            'hash_usernames' => true,       # Should usernames be hashed?
            'expire' => (86400 * 365),      # Expires in one year by default
            'tablename' => 'users'          # Table name for tokens and user id's / hashes
        );

        $this->config = array_merge($this->config, $config);
    }


    # Create a token
    public function createToken($userId)
    {
        $token = hash('sha256',mt_rand(0,1000));
        return $token;
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

