<?php

namespace Ampersand\Passwordless\TokenStore;

abstract class AbstractTokenStore
{
    abstract public function __construct($store, $config = array());

    # Create a token
    abstract public function createToken();

    # Get and set token in the store
    abstract public function setToken($userId, $token);
    abstract public function getToken($userId);
}

