<?php

/**
 * Class managing connection to the database and executing queries
 *
 */
class DBManager
{

    private static DBManager $instance;

    private PDO $connection;

    private function __construct()
    {
        $this->connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Instantiates the DBManager class
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
     * Get the PDO connection
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return PDOStatement
     */
    public function query(string $sql, ?array $params = null): PDOStatement
    {
        if ($params == null) {
            $query = $this->connection->query($sql);
        } else {
            $query = $this->connection->prepare($sql);
            $query->execute($params);
        }
        return $query;
    }
}