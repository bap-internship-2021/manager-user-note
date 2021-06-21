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
        setcookie('email', $email, strtotime('+ 1 year'), '/');
        setcookie('password', $password, strtotime('+ 1 year'), '/');
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
            $content = trim($content);
            $title = trim($title);
            // Validate
            $isOk = true;
            if ($title == null) {
                $_SESSION['note']['titleError'] = 'Title must be not null';
                $isOk = false;
            }
            if ($content == null) {
                $_SESSION['note']['contentError'] = 'Content must be not null';
                $isOk = false;
            }
            if ($isOk == true) {
                $ext = 'txt'; // extension
                $fileName = time() . $title . '.' . $ext; // Setting file name
                $path = 'public/notes/' . $fileName; // setting path of file name
                file_put_contents($path, $content); // writing content to file name
                if (parent::storeNote($userId, $title, $path, $content) === true) {
                    header('Location: .?action=list_notes');
                }
            } else {
                header('Location: .?action=create_note');
            }
        }
    }

    public function handleUploadNotes()
    {
        // Get current user
        $userId = $_SESSION['user_session']['id'];
        $data = [];

        // Get target file
        foreach ($_FILES['files']['name'] as $key => $noteName) {
            $data[$key]['title'] = $noteName; // Set title
            $noteName = time() . $noteName; // set note name file for ignore file same name
            $extension = pathinfo($noteName, PATHINFO_EXTENSION); // Get file extension
            $targetFile = 'public/notes/' . $noteName; // Set target file to store
            $data[$key]['targetFile'] = $targetFile;
            $data[$key]['extension'] = $extension;
        }
        // Get temp name
        foreach ($_FILES['files']['tmp_name'] as $key => $value) {
            $data[$key]['tmp_name'] = $value;
        }
        // Get file size
        foreach ($_FILES['files']['size'] as $key => $value) {
            $data[$key]['size'] = $value;
        }

        // Upload file
        foreach ($data as $key => $value) {
            $isOk = true; // Flag

            // Check file type
            if ($value['extension'] !== 'txt') {
                $_SESSION['upload_files']['extension'] = 'File extension only .txt!';
                $isOk = false;
            }
            // Check file size
            if ($value['size'] > 1000000) { // if file size > 1MB then fail
                $_SESSION['upload_files']['fileSize'] = 'File upload not more than 1MB!';
                $isOk = false;
            }

            if ($isOk == true) { // if true
                if (move_uploaded_file($value['tmp_name'], $value['targetFile'])) {
                    $content = file_get_contents($value['targetFile']);
                    if (parent::storeNote($userId, $value['title'], $value['targetFile'], $content)) {
                        header('Location: .?action=list_notes');
                    }
                }
            }
        }

    }
}