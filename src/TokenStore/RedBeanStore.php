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
            'tablename' => 'token'          # Table name for tokens and user id's / hashes
        );

        $this->config = array_merge($this->config, $config);
    }


    # Create a token
    public function createToken($userId)
    {
        $token = hash('sha256',mt_rand(0,1000));
        $this->setToken($userId,$token);
        return $token;
    }


    # Create user id hash
    public function createUserHash($userId)
    {
        return hash($this->config['hash_algorithm'],$userId);
    }


    public function setToken($userId, $token)
    {
        $token = R::dispense($this->config['tablename']);
        $token->user = $this->config['hash_usernames'] ? $this->createUserHash($userId) : $userId;
        $token->token = $token;
        R::store($token);
    }


    public function getToken($userId)
    {
        $token = R::load($this->config['tablename']);
        return $token->token;
    }

}

