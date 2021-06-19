<?php

class DatabaseConnect
{
    protected PDO $db;
    private string $dsn = 'mysql:host=localhost;dbname=manager_note';
    private string $username = 'root';
    private string $password = '';

    public function __construct()
    {
        $this->db = new PDO($this->dsn, $this->username, $this->password);
    }
}