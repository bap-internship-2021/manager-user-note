<?php

session_start(); // Start session
require_once('controllers/UserController.php'); // Require UserController
require_once 'controllers/NoteController.php'; // Require NoteController
$action = filter_input(INPUT_POST, 'action'); // default is post method

// Create new object of UserController class
$userController = new UserController();
// Create new object of NoteController class
$noteController = new NoteController();
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
        if ($user != false) {
            $_SESSION['user_session'] = $user;
            header('Location: .?action=home'); // Redirect to home page view
        } else {
            $_SESSION['login_message'] = 'Login fail!';
            header("Location: .?action=login");
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
        $userController->handleRegister();
        break;
    }
    case 'create_note' : // view create note
    {
        include_once 'views/notes/create-note.php';
        break;
    }
    case 'handle_store_note':
    {
        $userController->handle_store_note();
        break;
    }
    case 'upload_notes':
    {
        include_once 'views/notes/upload-note.php';
        break;
    }
    case 'handle_upload_notes':
    {
        $userController->handleUploadNotes();
        break;
    }
    case 'list_notes':
    {
        $notes = $noteController->handleListNotes();
        include 'views/notes/list-notes.php';
        break;
    }
    case 'edit_note':
    {
        $userId = $_SESSION['user_session']['id'];
        $id = filter_input(INPUT_GET, 'id');
        $note = $noteController->handleDetailNote($userId, $id);
        $path = $note['path'];
        include 'views/notes/edit-note.php';
        break;
    }
    case 'handle_edit_note':
    {
        $noteController->handleEditNote();
        break;
    }
    case 'detail_note':
    {
        $userId = $_SESSION['user_session']['id'];
        $noteId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $note = $noteController->handleDetailNote($userId, $noteId);

        include 'views/notes/detail-note.php';

        break;
    }
    case 'delete':
    {
        $userId = $userId = $_SESSION['user_session']['id'];
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $note = $noteController->handleDetailNote($userId, $id);
        if ($noteController->handleDelete($id) == true) {
            unlink($note['path']); // Delete file with path file
            $_SESSION['Delete']['success'] = 'Delete success!';
            header('Location: .?action=list_notes');
        } else {
            $_SESSION['Delete']['fail'] = 'Delete fail!';
            header('Location: .?action=list_notes');
        }
        break;
    }
    case 'download_note':
    {
        // Get path file from server
        $path = filter_input(INPUT_GET, 'path');
        //Check the file path exists or not
        if (file_exists($path)) {

            //Define header information
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Content-Length: ' . filesize($path));
            header('Pragma: public');

            //Clear system output buffer
            flush();

            //Read the size of the file
            readfile($path, true);

            //Terminate from the script
            die();

        }
        break;
    }
}