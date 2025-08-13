<?php

/**
 * Abstract manager handling database interaction
 */
abstract class AbstractEntityManager
{
    /**
     * @var PDO
     */
    protected PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}
