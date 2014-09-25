<?php

namespace Ampersand\Passwordless\TokenStore;

use Ampersand\Passwordless\TokenStore;
use R;


class RedBeanStore extends AbstractTokenStore
{

    private $config = array();


    public function __construct($config = array())
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
        $record = R::dispense($this->config['tablename']);
        $record->user = $this->config['hash_usernames'] ? $this->createUserHash($userId) : $userId;
        $record->token = $token;
        R::store($record);
    }


    public function getToken($token)
    {
        $record = R::findOne($this->config['tablename'],'token = ?', array($token));
        return $record;
    }


    public function getUserTokens($userId)
    {
        $userId = $this->config['hash_usernames'] ? $this->createUserHash($userId) : $userId;
        $records = R::find($this->config['tablename'],'user = ?', array($userId));
        return $records;
    }


    public function invalidateToken($token)
    {
        $record = $this->getToken( $token );

        if(is_object( $record )){
            R::trash($record);
            return true;
        }
        return false;
    }
}

