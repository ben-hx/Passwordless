<?php

namespace Ampersand\Passwordless\TokenStore;

interface TokenStoreInterface
{
    # Create a token
    public function createToken();

    # Get and set token in the store
    public function setToken();
    public function getToken();
}
