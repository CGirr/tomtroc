<?php

class ConversationManager extends AbstractEntityManager
{
    /**
     * @param int $userId
     * @return array
     */
    public function getUserConversationsWithNames(int $userId): array
    {
        $sql = "SELECT 
                    c.id AS id,
                    c.participant_one_id,
                    c.participant_two_id,
                    c.created_at,
                    u1.login AS participant_one_login,
                    u2.login AS participant_two_login,
                    u1.profile_picture AS participant_one_profile_picture,
                    u2.profile_picture AS participant_two_profile_picture,
                    m.content AS last_message_content,
                    m.sent_at AS last_message_sent_at,
                    m.sender_id AS last_message_sender_id
                FROM conversations c
                JOIN user u1 ON c.participant_one_id = u1.id
                JOIN user u2 ON c.participant_two_id = u2.id
                LEFT JOIN messages m 
                    ON m.id = (
                        SELECT m2.id
                        FROM messages m2
                        WHERE m2.conversation_id = c.id
                        ORDER BY m2.sent_at DESC
                        LIMIT 1
                )
                WHERE c.participant_one_id = :userId
                   OR c.participant_two_id = :userId
                ORDER BY m.sent_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * @param int $conversationId
     * @param int $userId
     * @return array|null
     */
    public function getConversationWithNamesById(int $conversationId, int $userId): ?array
    {
        $sql = "SELECT 
                c.id AS id,
                c.participant_one_id,
                c.participant_two_id,
                c.created_at,
                u1.login AS participant_one_login,
                u2.login AS participant_two_login,
                u1.profile_picture AS participant_one_profile_picture,
                u2.profile_picture AS participant_two_profile_picture
            FROM conversations c
            JOIN user u1 ON c.participant_one_id = u1.id
            JOIN user u2 ON c.participant_two_id = u2.id
            WHERE c.id = :conversationId
              AND (:userId = c.participant_one_id OR :userId = c.participant_two_id)
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'conversationId' => $conversationId,
            'userId' => $userId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * @param int $conversationId
     * @return Conversation|null
     */
    public function findConversationById(int $conversationId): ?Conversation
    {
        $sql = "SELECT * FROM conversations WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $conversationId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $conversation = new Conversation();
        $conversation->hydrate($row);

        return $conversation;
    }

    /**
     * @param int $sellerId
     * @param int $currentUserId
     * @return int
     */
    public function startNewConversation(int $sellerId, int $currentUserId): int
    {
        $sqlCheckIfExists = "SELECT id FROM conversations
                             WHERE (participant_one_id = :sellerId AND participant_two_id = :currentUserId) 
                                OR (participant_one_id = :currentUserId AND participant_two_id = :sellerId)";
        $stmtCheckifExists = $this->db->prepare($sqlCheckIfExists);
        $stmtCheckifExists->execute(['sellerId' => $sellerId, 'currentUserId' => $currentUserId]);
        $exists = $stmtCheckifExists->fetch();

        var_dump($exists);

        if ($exists) {
            return $exists['id'];
        }

        $sql = "INSERT INTO conversations (participant_one_id, participant_two_id, created_at)
                VALUES (:sellerId, :currentUserId, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['sellerId' => $sellerId, 'currentUserId' => $currentUserId]);

        return (int)$this->db->lastInsertId();
    }
}