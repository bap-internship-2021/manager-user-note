<?php
require './models/User.php';

class UserController extends User
{
    public function handleLogin()
    {
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        return $this->login($email, $password); // Call login from User model
    }
}