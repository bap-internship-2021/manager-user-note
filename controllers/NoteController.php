<?php

require_once 'models/Note.php';

class NoteController extends Note
{
    /**
     * @return array|false|void
     */
    public function handleListNotes()
    {
        if (isset($_SESSION['user_session'])) {
            $userId = $_SESSION['user_session']['id'];
            // Get notes
            return parent::listNotes($userId);
        }
    }

    public function handleDetailNote($userId, $noteId)
    {
        return parent::detailNote($userId, $noteId);
    }

    public function handleEditNote()
    {
        if (isset($_SESSION['user_session'])) {
            $path = filter_input(INPUT_POST, 'path');
            $noteId = filter_input(INPUT_POST, 'note-id');
            $userId = $_SESSION['user_session']['id'];
            $title = trim(filter_input(INPUT_POST, 'title'));
            $content = trim(filter_input(INPUT_POST, 'content'));
            echo '<pre>';

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
                if (parent::editNote($userId, $noteId, $title, $content) === true) {
                    if (file_exists($path)) {
                        $myFile = fopen($path, 'w+') or die("Unable to open file");
                        fwrite($myFile, $content);
                        fclose($myFile);
                    }
                    $_SESSION['note']['editSuccess'] = 'Update success';
                    header('Location: .?action=edit_note&id=' . $noteId);
                } else {
                    echo 'Some thing went wrong!, Please try again';
                    exit();
                }
            } else {
                header('Location: .?action=edit_note&id=' . $noteId);
            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function handleDelete($id): bool
    {
        if (parent::deleteNote($id) == true) {
            return true;
        } else {
            echo 'OK';
            exit();
            return false;
        }
    }
}