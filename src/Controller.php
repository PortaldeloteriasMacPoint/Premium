<?php

namespace App;

class Controller
{
    private $authController;
    private $database;

    public function __construct($firebase)
    {
        $this->authController = new AuthController($firebase);
        $this->database = new Database($firebase);
    }

    public function handleRequest()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader) {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["error" => "Authorization header missing"]);
            return;
        }

        $idToken = str_replace('Bearer ', '', $authHeader);
        $verifiedToken = $this->authController->verifyIdToken($idToken);

        if (!$verifiedToken) {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["error" => "Invalid token"]);
            return;
        }

        $uid = $verifiedToken->getClaim('sub');
        $userData = $this->database->getUserData($uid);

        if (!$userData) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["error" => "User not found"]);
            return;
        }

        if (!$this->isSubscriptionActive($userData)) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode(["error" => "Subscription expired"]);
            return;
        }

        echo json_encode($userData);
    }

    private function isSubscriptionActive($userData)
    {
        if (!isset($userData['status']) || $userData['status'] !== 'ativo') {
            return false;
        }

        if (!isset($userData['subscriptionEndDate'])) {
            return false;
        }

        $expirationDate = strtotime($userData['subscriptionEndDate']);
        return $expirationDate > time();
    }
}

