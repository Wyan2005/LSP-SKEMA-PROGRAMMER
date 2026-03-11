<?php

class Model
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
}