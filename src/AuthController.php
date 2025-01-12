<?php

namespace App;

use Firebase\Auth\Token\Exception\InvalidToken;

class AuthController
{
    private $auth;

    public function __construct($firebase)
    {
        $this->auth = $firebase->createAuth();
    }

    public function verifyIdToken($idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken;
        } catch (InvalidToken $e) {
            return null;
        }
    }
}

