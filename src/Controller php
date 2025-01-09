<?php

namespace App;

use Firebase\Auth;

class Controller
{
    private $auth;
    private $db;

    public function __construct($firebase)
    {
        $this->auth = $firebase->createAuth();
        $this->db = new Database($firebase);
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uid = $_GET['uid'] ?? null;

        if ($method === 'GET' && $url === '/api/user' && $uid) {
            $this->getUserData($uid);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo 'Endpoint not found';
        }
    }

    private function getUserData($uid)
    {
        $userData = $this->db->getUserData($uid);

        if ($userData) {
            header('Content-Type: application/json');
            echo json_encode($userData);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo 'User not found';
        }
    }
}

