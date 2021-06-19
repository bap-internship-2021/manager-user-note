<?php

session_start(); // Start session
require_once('controllers/UserController.php'); // Require UserController

$action = filter_input(INPUT_POST, 'action'); // default is post method

// Create new object of UserController class
$userController = new UserController();

if ($action == null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == null) {
        $action = 'home';
    }
}

if (!empty($_SESSION['user_session'])){
    if (in_array($action, ['login', 'handle_login'])) {
        header('Location: /'); // Return redirect back
        exit();
    }
}

switch ($action) {
    case 'home':
    {
        include './views/home.php';
        break;
    }
    case 'login':
    {
        include 'views/users/login.php';
        break;
    }
    case 'handle_login':
    {
        // Try attempt login
        $user = $userController->handleLogin();
        if ($user == true) {
            $_SESSION['user_session'] = $user;
            header('Location: .?action=home'); // Redirect to home page view
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Return back login form view
        break;
    }
}