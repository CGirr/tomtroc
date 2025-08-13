<?php

/**
 * Class ManagerFactory
 * Provides centralized access to entity Managers
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

    /**
     * Returns an instance of BookManage
     * @return BookManager
     */
    public static function getBookManager(): BookManager
    {
        $db = DBManager::getInstance()->getConnection();
        return new BookManager($db);
    }

    /**
     * @return MessageManager
     */
    public static function getMessageManager(): MessageManager
    {
        $db = DBManager::getInstance()->getConnection();
        return new MessageManager($db);
    }

    /**
     * @return ConversationManager
     */
    public static function getConversationManager(): ConversationManager
    {
        $db = DBManager::getInstance()->getConnection();
        return new ConversationManager($db);
    }
}