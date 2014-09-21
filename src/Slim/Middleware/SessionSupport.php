<?php
/*
* Passwordless token-based authentication
*
* Copyright (c) 2014 Thomas Klokosch
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Project home:
* https://github.com/thomasklokosch/GetAmpersand/Passwordless
*
*/
namespace Ampersand\Passwordless\Slim\Middleware;

/*
 *
 */
class SessionSupport extends \Slim\Middleware
{
    private $tokenStore;
    private $sessionStore;

    public function __construct($tokenStore, $sessionStore)
    {
        // TODO: Check if tokenStore is valid
        $this->tokenStore = $tokenStore;
        $this->sessionStore = $sessionStore;
    }

    public function call()
    {
        if(!isset($_SESSION['passwordless']['session'])){

            $this->app->log->info("Restoring user from session");

            $sessionData = $this->sessionStore->getSessionData();

            if(is_object($sessionData)){
                $this->app->log->info("Success for user: ".$sessionData->user);
            }

        }

        $this->next->call();
    }

}

