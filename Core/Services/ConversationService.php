<?php

class ConversationService
{
    private ConversationManager $conversationManager;

    public function __construct()
    {
        $this->conversationManager = ManagerFactory::getConversationManager();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserConversations(int $userId): array
    {
        $rows = $this->conversationManager->getUserConversationsWithNames($userId);
        $conversations = [];

        foreach ($rows as $row) {
            $conversations[] = $this->prepareConversationModel($row, $userId);
        }

        return $conversations;
    }

    /**
     * @param int $sellerId
     * @param int $currentUserId
     * @return ConversationModel
     * @throws Exception
     */
    public function startOrGetConversation(int $sellerId, int $currentUserId): ConversationModel
    {
        $conversationId = $this->conversationManager->startNewConversation($sellerId, $currentUserId);

        $row = $this->conversationManager->getConversationWithNamesById($conversationId, $currentUserId);
        if (!$row) {
            throw new Exception("Conversation introuvable", 404);
        }

        $conversation = $this->prepareConversationModel($row, $currentUserId);

        $this->validateConversation($conversation, $currentUserId);

        return $conversation;
    }

    /**
     * @param ConversationModel|null $conversation
     * @param int $currentUserId
     * @return void
     * @throws Exception
     */
    public function validateConversation(?ConversationModel $conversation, int $currentUserId): void
    {
        if (!$conversation) {
            throw new Exception("Conversation introuvable", 404);
        }

        if (!$conversation->hasParticipant($currentUserId)) {
            throw new Exception("Accès refusé à cette conversation", 403);
        }
    }

    /**
     * @param int $conversationId
     * @param int $currentUserId
     * @return ConversationModel
     * @throws Exception
     */
    public function getConversationOrFail(int $conversationId, int $currentUserId): ConversationModel
    {
        $row = $this->conversationManager->getConversationWithNamesById($conversationId, $currentUserId);
        if (!$row) {
            throw new Exception("Conversation introuvable", 404);
        }

        return $this->prepareConversationModel($row, $currentUserId);
    }

    private function prepareConversationModel(array $row, int $userId): ConversationModel
    {
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

        return new ConversationModel(
            $conversation,
            $otherName,
            $otherPhoto,
            $lastMessage
        );
    }
}