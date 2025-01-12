<?php

use Firebase\Factory;
use Firebase\ServiceAccount;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$firebase = (new Factory())
    ->withServiceAccount([
        'type' => 'service_account',
        'project_id' => $_ENV['FIREBASE_PROJECT_ID'],
        'private_key_id' => $_ENV['FIREBASE_PRIVATE_KEY_ID'],
        'private_key' => $_ENV['FIREBASE_PRIVATE_KEY'],
        'client_email' => $_ENV['FIREBASE_CLIENT_EMAIL'],
        'client_id' => $_ENV['FIREBASE_CLIENT_ID'],
        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
        'token_uri' => 'https://oauth2.googleapis.com/token',
        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
        'client_x509_cert_url' => $_ENV['FIREBASE_CLIENT_X509_CERT_URL'],
    ])
    ->create();

