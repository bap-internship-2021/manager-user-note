<?php
require_once('DatabaseConnect.php');

class User extends DatabaseConnect
{
    public function login($email, $password)
    {
        $query = 'SELECT id, email, password FROM users WHERE email = :email AND password = :password';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $user;
    }
}
