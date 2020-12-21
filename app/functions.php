<?php

declare(strict_types=1);

//Login functions
// checkUserName
// checkPassword

function loginUser(array $user, object $db): void
{

    $stmnt = $db->prepare("SELECT email, user_name FROM users WHERE email = :email");
    $stmnt->bindParam(":email", $user['email'], PDO::PARAM_STR);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($db->errorInfo()));
    }

    $user = $stmnt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;
}

//Signup functions

function emptyInput(array $user): bool
{
    foreach ($user as $userProperty) {
        if (empty($userProperty)) {
            return true;
        }
    }
    return false;
}

function passwordCheck(string $password, string $passwordCheck): bool
{
    if ($password === $passwordCheck) {
        return true;
    }
    return false;
}

function validEmail(string $email): bool
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function userNameExists(string $userName, object $db): bool
{
    $stmnt = $db->prepare("SELECT user_name FROM users WHERE user_name = :user_name");
    $stmnt->bindParam(":user_name", $userName, PDO::PARAM_STR);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($db->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return true;
    }

    return false;
}

function userEmailExists(string $email, object $db): bool
{
    $stmnt = $db->prepare("SELECT email FROM users WHERE email = :email");
    $stmnt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($db->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return true;
    }

    return false;
}

function createUser(array $newUser, object $db): void
{
    $stmnt = $db->prepare("INSERT INTO users (user_name, email, password) VALUES (:user_name, :email, :password)");
    $stmnt->bindParam(":user_name", $newUser['user_name'], PDO::PARAM_STR);
    $stmnt->bindParam(":email", $newUser['email'], PDO::PARAM_STR);
    $stmnt->bindParam(":password", $newUser['password'], PDO::PARAM_STR);
    $stmnt->execute();
    if (!$stmnt) {
        die(var_dump($db->errorInfo()));
    }
}

// validUserName ? 