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

    // Constructor function needs to be given a valid tokenStore
    public function __construct($tokenStore)
    {
        // TODO: Check if tokenStore is valid
        $this->tokenStore = $tokenStore;
    }

    public function call() {

        $token = $this->app->request->get('token');
        $this->app->log->info("Token: ".$token);
        if($token){
            if($this->tokenStore->invalidateToken($token)){
                $this->app->log->info("Valid token");
            } else {
                $this->app->log->error("Invalid token");
            }
        }

        $this->next->call();
    }

}

