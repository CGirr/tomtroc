<?php

/**
 *
 */
class MessageManager extends AbstractEntityManager
{
    /**
     * @param int $conversationId
     * @return array
     */
    public function findMessagesByConversationId(int $conversationId): array
    {
        $sql = "SELECT * FROM messages WHERE conversation_id = :conversation_id ORDER BY sent_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            "conversation_id" => $conversationId
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function addMessage(Message $message): bool
    {
        $sql = "INSERT INTO messages (conversation_id, sender_id, content, sent_at)
               VALUES (:conversation_id, :sender_id, :content, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            "conversation_id" => $message->getConversationId(),
            "sender_id" => $message->getSenderId(),
            "content" => $message->getContent(),
        ]);
    }

    public function markMessagesAsRead(int $conversationId, int $userId): void
    {
        $sql = "UPDATE messages 
                SET is_read = 1
                WHERE conversation_id = :conversation_id
                AND sender_id != :user_id
                AND is_read = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            "conversation_id" => $conversationId,
            "user_id" => $userId
        ]);
    }
}