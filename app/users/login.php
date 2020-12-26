<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {

    $user = [
        "email" => $_POST['email'],
        "password" => $_POST['password']
    ];

    if (!loginUser($user, $db)) {
        header("location: /../../login.php");
        exit;
    }

    unset($user);
}

header("Location: /");