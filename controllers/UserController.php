<?php
require './models/User.php';

class UserController extends User
{
    public function handleLogin()
    {
        // Get input
        $email = trim(filter_input(INPUT_POST, "email"));
        $password = trim(filter_input(INPUT_POST, "password"));
//        $email = trim($email);
//        $password = trim($password);
        return $this->login($email, $password); // Call login from User model
    }
}