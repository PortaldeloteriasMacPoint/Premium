<?php

namespace App;

use Firebase\Database;

class Database
{
    private $database;

    public function __construct($firebase)
    {
        $this->database = $firebase->createDatabase();
    }

    public function getUserData($uid)
    {
        $ref = $this->database->getReference('users/' . $uid);
        return $ref->getValue();
    }

    public function createUser($uid, $data)
    {
        $this->database->getReference('users/' . $uid)
            ->set($data);
    }
}

