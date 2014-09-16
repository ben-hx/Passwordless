<?php

namespace Ampersand\Passwordless\TokenStore;

abstract class AbstractTokenStore
{
    abstract public function __construct($config = array());

    # Create a token
    abstract public function createToken($userId);
    abstract public function createUserHash($userId);

    # Get and set token in the store
    abstract public function setToken($userId, $token);
    abstract public function getToken($token);
    abstract public function getUserTokens($userId);

    # Validate token
    abstract public function invalidateToken($token);
}

