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
use \Ampersand\Passwordless\TokenStore;

/*
 *
 */
class AcceptToken extends \Slim\Middleware
{
    private $tokenStore;
    private $sessionStore;

    // Constructor function needs to be given a valid tokenStore
    public function __construct($tokenStore, $sessionStore)
    {
        // TODO: Check if tokenStore is valid
        $this->tokenStore = $tokenStore;
        $this->sessionStore = $sessionStore;
    }

    public function call() {

        $token = $this->app->request->get('token');
        $userId = $this->app->request->get('user');

        if($token){
            if($this->tokenStore->invalidateToken($token)){

                # The token is available and hasn't been invalidated yet
                $this->app->log->info("Valid token: ".$token);

                # Create a session in the store
                $this->sessionStore->createSession($userId);

                # Redirect to root page
                # TODO: Make configurable
                $this->app->redirect('/');

            } else {

                # The token is not found or not valid anymore
                $this->app->log->error("Invalid token: ".$token);

            }
        }

        $this->next->call();
    }

}

