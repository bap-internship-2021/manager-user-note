<?php
require './models/User.php';

class UserController extends User
{
    /**
     * Login
     * @return mixed
     */
    public function handleLogin()
    {
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $password = md5($password);
        // Call login from User model
        return parent::login($email, $password);
    }

    public function handleRegister(): bool
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $password_confirmation = filter_input(INPUT_POST, 'password_confirmation');
        $name = filter_input(INPUT_POST, 'name');
        $phone = filter_input(INPUT_POST, 'phone');

        if ($password === $password_confirmation) {
            $password = md5($password);

            // Register
            $result = parent::register($email, $password, $name, $phone);
            if ($result == true) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

}