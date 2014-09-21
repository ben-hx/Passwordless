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
        $cookieData['user'] = $userHash;
        $cookieData['session'] = $sessionId;

        # Set the cookie
        setCookie($this->config['cookie_name'], json_encode($cookieData), time()+$this->config['expire'], $this->config['cookie_path']);

        # Set the $_SESSION variables
        $this->setSession( $userHash, $sessionId);

        $record = R::dispense($this->config['tablename']);
        $record->user = $userHash;
        $record->session = $sessionId;
        R::store($record);
    }


    public function destroySession($sessionId)
    {
        # Remove cookie by setting the expiration time to the past
        setcookie($this->config['cookie_name'], '', time()-3600);

        # Unset session variables
        unset($_SESSION['passwordless']);

        # Get user session record from database and remove it
        $record = R::findOne($this->config['tablename'],'session = ?', [$sessionId]);
        R::trash($record);
    }


    # Create user id hash
    public function createUserHash($userId)
    {
        return hash($this->config['hash_algorithm'],$userId);
    }


    public function getSessionData()
    {
        if(isset($_COOKIE[$this->config['cookie_name']]) && !empty($_COOKIE[$this->config['cookie_name']])){

            # Get cookie data as array, user and session id
            $cookieData = json_decode($_COOKIE[$this->config['cookie_name']],true);

            # Get user session record from database
            $record = R::findOne($this->config['tablename'],'user = ? AND session = ?', array($cookieData['user'],$cookieData['session']));

            # If the session is already registered in the database,
            # set the $_SESSION variables
            if (is_object($record)) $this->setSession( $record->user, $record->session );

            return $record;
        }

        return false;
    }


    private function setSession( $user, $session)
    {
        # Set the $_SESSION variables
        $_SESSION['passwordless']['user'] = $user;
        $_SESSION['passwordless']['session'] = $session;
    }

}
