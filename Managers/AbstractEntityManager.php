<?php

/**
 * Abstract manager handling database interaction
 */
abstract class AbstractEntityManager
{

    protected PDO $db;

    public function __construct()
    {
        $this->db = DBManager::getInstance()->getConnection();
    }
}