<?php
require_once('DatabaseConnect.php');

class User extends DatabaseConnect
{

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        try {
            $query = 'SELECT id, email, password FROM users WHERE email = :email AND password = :password';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password, PDO::PARAM_STR_CHAR);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();
           return $user;
        } catch (PDOException | Exception $exception) {
            die($exception->getMessage());
        }

    }

    public function register($email, $password, $name, $phone)
    {
        // Checking email
        try {
            $query = 'SELECT email FROM users WHERE email = :email';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor(); // close the cursor
            if ($user === false) { // If email  exists in users table then return false
                try {
                    // Start transaction
                    $this->db->beginTransaction();
                    $query = 'INSERT INTO users (email, password) VALUES (:email, :password)';

                    $statement = $this->db->prepare($query);
                    $statement->bindValue(':email', $email);
                    $statement->bindValue(':password', $password);
                    $statement->execute();
                    $statement->closeCursor();

                    // search id of user has create on users table
                    $query = "SELECT id FROM users WHERE email = :email";
                    $statement = $this->db->prepare($query);
                    $statement->bindValue(":email", $email);
                    $statement->execute();
                    $user = $statement->fetch(PDO::FETCH_ASSOC);
                    $statement->closeCursor();
                    $userId = $user['id']; // Get user id has created at users table

                    // Create profile with user id = $userId
                    $query = 'INSERT INTO profiles (user_id, name, phone) VALUES (:user_id, :name, :phone)';
                    $statement = $this->db->prepare($query);
                    $statement->bindValue(':user_id', $userId);
                    $statement->bindValue(':name', $name);
                    $statement->bindValue(':phone', $phone, PDO::PARAM_INT);
                    $statement->execute();
                    $statement->closeCursor();

                    // All good
                    $this->db->commit();
                    return true;
                } catch (PDOException | Exception $exception) {
                    // Something went wrong
                    $this->db->rollBack();
                    echo $exception->getMessage();
                    return false;
                }
            }
        } catch (PDOException | Exception $exception) {
            echo $exception->getMessage();
            return false;
        }

    }
}
