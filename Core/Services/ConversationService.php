<?php

class ConversationService
{
    private ConversationManager $conversationManager;

    public function __construct()
    {
        $this->conversationManager = ManagerFactory::getConversationManager();
    }

    public function getUserConversations(int $userId): array
    {
        $rows = $this->conversationManager->getUserConversationsWithNames($userId);
        $conversations = [];

        foreach ($rows as $row) {
            $conversation = new Conversation();
            $conversation->hydrate($row);

            if ($row['participant_one_id'] === $userId) {
                $otherName = $row['participant_two_login'];
                $otherPhoto = $row['participant_two_profile_picture'] ?? null;
            } else {
                $otherName = $row['participant_one_login'];
                $otherPhoto = $row['participant_one_profile_picture'] ?? null;
            }

            $lastMessage = null;
            if (!empty($row['last_message_content'])) {
                $messageData = [
                    'content' => $row['last_message_content'],
                    'sent_at' => $row['last_message_sent_at'],
                    'sender_id' => $row['last_message_sender_id'],
                ];

                $message = new Message();
                $message->hydrate($messageData);

                $lastMessage = new MessageModel($message);
            }

            $conversations[] = new ConversationModel(
                $conversation,
                $otherName,
                $otherPhoto,
                $lastMessage
            );
        }

        return $conversations;
    }
}