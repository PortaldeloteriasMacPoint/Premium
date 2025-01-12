<?php

namespace App;

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Verifier;

class Auth
{
    private $auth;
    private $database;

    public function __construct($firebase)
    {
        $this->auth = $firebase->createAuth();
        $this->database = $firebase->createDatabase();
    }

    public function verifyToken($idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken;
        } catch (InvalidToken $e) {
            throw new \Exception("Invalid ID token.");
        }
    }

    public function getUser($uid)
    {
        try {
            $user = $this->auth->getUser($uid);
            return $user;
        } catch (\Firebase\Auth\Exception\AuthException $e) {
            throw new \Exception("User not found.");
        }
    }

    public function getUserFromDatabase($uid)
    {
        $ref = $this->database->getReference('users/' . $uid);
        return $ref->getValue();
    }
}


