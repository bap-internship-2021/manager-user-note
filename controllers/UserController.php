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

    public function handleRegister()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $password_confirmation = filter_input(INPUT_POST, 'password_confirmation');
        $name = filter_input(INPUT_POST, 'name');
        $phone = filter_input(INPUT_POST, 'phone');
        $isOk = true; // flag
        $_SESSION['register_error'] = [];
        if ($email == null) {
            $isOk = false;
            $_SESSION['register_error']['email'] = 'Required email';
        }
        if ($name == null) {
            $isOk = false;
            $_SESSION['register_error']['name'] = 'Required name';
        }
        if ($phone == null) {
            $isOk = false;
            $_SESSION['register_error']['phone'] = 'Required phone';
        } else if (!is_numeric($phone)) {
            $isOk = false;
            $_SESSION['register_error']['phone'] = 'Phone must be a number';
        }
        if ($password == null) {
            $isOk = false;
            $_SESSION['register_error']['password'] = 'Required password';
        } else if ($password !== $password_confirmation) {
            $isOk = false;
            $_SESSION['register_error']['password_confirmation'] = 'Password confirmation must be same password';
        }


        // if everything is OK
        if ($isOk == true) {
            $password = md5($password);// Md5 input password
            // Register
            $result = parent::register($email, $password, $name, $phone);
//var_dump($result);
//exit();
            if ($result === -1) // if email exists
            {
                $_SESSION['email_exists'] = 'Register fail! This email have exists in system, please try another email!';
                header("Location: .?action=register");
            }
            if ($result == true) { // if result is true
                $_SESSION['register_success'] = 'Register success';
                header("Location: .?action=register");
            }  else { // Some thing went wrong
                $_SESSION['register_message'] = 'Something error!';
                header("Location: .?action=register");
            }
        }
        header("Location: .?action=register");
    }

}