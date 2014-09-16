<?php

namespace Ampersand\Passwordless\SessionStore;

use Ampersand\Passwordless\SessionStore;
use R;


class RedBeanStore extends AbstractSessionStore
{
    private $config = array();
    private $cookieData = array();

    public function __construct($config = array())
    {
        $this->config = array(
            'hash_algorithm' => 'sha256',   # Use sha256 hash for user id
            'hash_usernames' => true,       # Should usernames be hashed?
            'cookie_name' => 'passwordless', # Cookie name
            'cookie_path' => '/',
            'cookie_domain' => 'localhost',
            'expire' => 86400,              # Expires in one week by default
            'tablename' => 'session'        # Table name for tokens and user id's / hashes
        );

        $this->config = array_merge($this->config, $config);
    }


    public function createSession($userId)
    {
        # Hash username if option is set
        $userHash = $this->config['hash_usernames'] ? $this->createUserHash($userId) : $userId;

        # Get a random session identifier
        $sessionId = hash('sha256',mt_rand(0,1000));

        # Setup session data for storage in the cookie
        $cookieData['userId'] = $userId;
        $cookieData['sessionId'] = $sessionId;

        # Set the cookie
        setCookie($this->config['cookie_name'], json_encode($cookieData), time()+$this->config['expire'], $this->config['cookie_path']);

        $record = R::dispense($this->config['tablename']);
        $record->user = $userHash;
        R::store($record);
    }


    # Create user id hash
    public function createUserHash($userId)
    {
        return hash($this->config['hash_algorithm'],$userId);
    }

}
