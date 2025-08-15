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
     * @throws Exception
     */
    public function sendMessage(int $conversationId, int $senderId, string $content): bool
    {
        $content = trim($content);
        if ($content === '' || mb_strlen($content) > 1000) {
            throw new Exception("Message invalide", 400);
        }

        $conversation = ManagerFactory::getConversationManager()->findConversationById($conversationId);

        if (!$conversation) {
            throw new Exception("Conversation introuvable", 404);
        }

        if (!$conversation->hasParticipant($senderId)) {
            throw new Exception("Accès refusé à cette conversation", 403);
        }

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

    /**
     * @param int $userId
     * @return int
     */
    public function countUnreadMessages(int $userId): int
    {
        return $this->messageManager->countUnreadMessages($userId);
    }
}