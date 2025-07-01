<?php

/**
 * Abstract manager handling database interaction
 */
abstract class AbstractEntityManager {

    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = DBManager::getInstance()->getConnection();
    }
}