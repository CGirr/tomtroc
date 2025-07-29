<?php

/**
 * Class ManagerFactory
 * Provides centralized access to entity managers
 */
class ManagerFactory
{
    /**
     * Returns an instance of UserManager
     * @return UserManager
     */
    public static function getUserManager(): UserManager
    {
        $db = DBManager::getInstance()->getConnection();
        return new UserManager($db);
    }

    public static function getBookManager(): BookManager
    {
        $db = DBManager::getInstance()->getConnection();
        return new BookManager($db);
    }
}