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
            $_SESSION['register_error']['email'] = 'Required email or email is not valid';
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

            if ($result === -1) // if email exists
            {
                $_SESSION['email_exists'] = 'Register fail! This email have exists in system, please try another email!';
                header("Location: .?action=register");
            }
            if ($result == true) { // if result is true
                $_SESSION['register_success'] = 'Register success';
                header("Location: .?action=register");
            } else { // Some thing went wrong
                $_SESSION['register_message'] = 'Something error!';
                header("Location: .?action=register");
            }
        }
        header("Location: .?action=register");
    }

    public function handle_store_note()
    {
        if (isset($_SESSION['user_session'])) {
            $userId = $_SESSION['user_session']['id'];
            $title = filter_input(INPUT_POST, 'title');
            $content = filter_input(INPUT_POST, 'content');
            $content = trim(htmlspecialchars($content));
            $title = trim(htmlspecialchars($title));
            $ext = 'txt';
            $fileName = time() . $title . '.' . $ext;

            $path = './public/notes/' . $fileName;
            echo '<pre>';

            file_put_contents($path, $content);

            parent::storeNote($userId, $title, $path, $content);
        }
    }
}