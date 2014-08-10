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
class AcceptToken extends \Slim\Middleware
{

    public function __construct()
    {

    }

    public function call()
    {
        $this->next->call();
    }

}

