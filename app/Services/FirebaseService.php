<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;

    public function __construct()
{
    $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
    $this->auth = $factory->createAuth();
}
public function countUsers(): int
{
    $users = $this->auth->listUsers(1000); // Max 1000 users
    $count = 0;

    foreach ($users as $user) {
        $count++;
    }

    return $count;
}
}
