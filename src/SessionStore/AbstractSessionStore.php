<?php

namespace Ampersand\Passwordless\SessionStore;

abstract class AbstractSessionStore
{
    abstract public function __construct($config = array());

    # Create a session entry
    abstract public function createSession($userName);
}

