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
}