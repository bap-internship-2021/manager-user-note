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

if (!empty($_SESSION['user_session'])) { // if user authenticate
    if (in_array($action, ['login', 'handle_login', 'register'])) { // if action are login and handle_login then redirect to root directory
        header('Location: /'); // Return redirect back
    }
}

switch ($action) {
    case 'home':
    {
        include './views/home.php';
        break;
    }
    case 'login': // Show form login
    {
        include 'views/users/login.php';
        break;
    }
    case 'handle_login': // Handle checking login
    {
        // Try attempt login
        $user = $userController->handleLogin();
        if ($user == true) {
            $_SESSION['user_session'] = $user;
            header('Location: .?action=home'); // Redirect to home page view
        } else {
            $error = 'login error';
            include 'views/users/login.php';
        }
        break;
    }
    case 'logout' : // user logout
    {
        session_destroy();
        header('Location: /'); // Return home
        break;
    }
    case 'register': // show form
    {
        include_once 'views/users/register.php';
        break;
    }
    case 'handle_register': // Register user
    {
        $result = $userController->handleRegister();
        if ($result === true) {
            $_SESSION['register_message'] = 'Register success';
            header('Location: .?action=login');
        } else {
            $error = 'Register fail';
            include 'views/users/register.php';
        }
        break;
    }

}