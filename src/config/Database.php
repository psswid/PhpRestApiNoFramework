<?php

/**
 * Database configuration options
 */
class Database
{
    /**
     * To constructor from .env
     */
    private $DB_HOST;
    private $DB_PORT;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;


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
            header("HTTP/1.1 500 Internal Server Error");
            print_r(json_encode('Connection error: ' . $e->getMessage()));
            exit();
        }

        return $this->connection;
    }
}