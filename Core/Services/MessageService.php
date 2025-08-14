<?php

/**
 *
 */
class MessageService
{
    /**
     * @var MessageManager
     */
    private MessageManager $messageManager;

    /**
     *
     */
    public function __construct()
    {
        $this->messageManager = ManagerFactory::getMessageManager();
    }

    /**
     * @param int $conversationId
     * @param int $senderId
     * @param string $content
     * @return bool
     */
    public function sendMessage(int $conversationId, int $senderId, string $content): bool
    {
        $message = new Message();
        $message->setConversationId($conversationId);
        $message->setSenderId($senderId);
        $message->setContent($content);

        return $this->messageManager->addMessage($message);
    }

    /**
     * @param int $conversationId
     * @param int $currentUserId
     * @return array
     */
    public function getMessagesByConversationId(int $conversationId, int $currentUserId): array
    {
        $rows = $this->messageManager->findMessagesByConversationId($conversationId);
        $messages = [];

        foreach ($rows as $row) {
            $message = new Message($row);
            $message->hydrate($row);

            $messageModel = new MessageModel($message);
            $messageModel->setIsMine($row['sender_id'] === $currentUserId);

            $messages[] = $messageModel;
        }

        return $messages;
    }

    /**
     * @param int $conversationId
     * @param int $userId
     * @return void
     */
    public function markMessagesAsRead(int $conversationId, int $userId): void
    {
        $this->messageManager->markMessagesAsRead($conversationId, $userId);
    }

    public function countUnreadMessages(int $userId): int
    {
        return $this->messageManager->countUnreadMessages($userId);
    }
}