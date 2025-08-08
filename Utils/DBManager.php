<?php

/**
 * Class DBManager
 *
 * Handles the connection to the database using PDO.
 * Implements the singleton pattern to ensure a single shared instance.
 */
class DBManager
{
    private static DBManager $instance;
    private PDO $connection;

    /**
     * DBManager constructor.
     * Initializes the PDO connection.
     */
    private function __construct()
    {
        $this->connection = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
            DB_USER,
            DB_PASS
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Returns the singleton instance of DBManager.
     *
     * @return DBManager
     */
    public static function getInstance(): DBManager
    {
        if (!isset(self::$instance)) {
            self::$instance = new DBManager();
        }

        return self::$instance;
    }

    /**
     * Returns the PDO database connection.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
