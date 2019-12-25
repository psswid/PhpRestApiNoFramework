<?php

/**
 * Database configuration options
 */
class Database
{

    /**
     * Db parameters
     *
     * note: should be done with .env variables
     */
    private $host = 'localhost';
    private $dbName = 'RestApiNF';
    private $user = 'root';
    private $password = 'root';
    private $connection;

    /**
     * Db Connection
     */
    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->host .
                ';dbname=' . $this->dbName,
                $this->user,
                $this->password
            );

            /**
             * Exceptions information
             */
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->connection;
    }
}