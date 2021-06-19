<?php

class DatabaseConnect
{
    protected $db;
    private $dsn = 'mysql:host=localhost;dbname=manager_note';
    private $username = 'root';
    private $password = '';

    public function __construct()
    {
        $this->db = new PDO($this->dsn, $this->username, $this->password);
    }
}