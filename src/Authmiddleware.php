

<?php

namespace App;

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Verifier;

class AuthMiddleware
{
    private $verifier;

    public function __construct()
    {
        $this->verifier = new Verifier(getenv('FIREBASE_PROJECT_ID'));
    }

    public function validateToken($idToken)
    {
        try {
            $verifiedIdToken = $this->verifier->verifyIdToken($idToken);
            return $verifiedIdToken->getClaims();
        } catch (InvalidToken $e) {
            return false;
        }
    }
}

