<?php
require_once 'models/DatabaseConnect.php';

class Note extends DatabaseConnect
{
    /**
     * @param $userId
     * @return array|false|void
     */
    public function listNotes($userId)
    {
        try {
            $query = 'SELECT id, title, content, path FROM notes WHERE user_id = :userId';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':userId', $userId);
            $statement->execute();
            $notes = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $notes;
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @param $userId
     * @param $noteId
     * @param $content
     * @param $title
     * @return mixed|void
     */
    public function detailNote($userId, $noteId)
    {
        try {
            $query = 'SELECT id, title, content, path FROM notes WHERE (user_id = :userId) AND (id = :nodeId)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':userId', $userId);
            $stmt->bindValue(':nodeId', $noteId);
            $stmt->execute();
            $note = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $note;
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @param $userId
     * @param $noteId
     * @param $title
     * @param $content
     * @return bool|void
     */
    public function editNote($userId, $noteId, $title, $content)
    {
        try {
            $query = 'UPDATE notes SET title = :title, content = :content WHERE (user_id = :userId) AND (id = :noteId)';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':noteId', $noteId);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':content', $content);
            $stmt->bindValue(':userId', $userId);
            $result = $stmt->execute();
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $exception) {
            echo($exception->getMessage());
        }
    }
}