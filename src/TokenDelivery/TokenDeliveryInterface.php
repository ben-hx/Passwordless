<?php

namespace Ampersand\Passwordless\TokenDelivery;

interface TokenDeliveryInterface
{
    public function deliver( $token, $userId, $mail = '');
}
