<?php

/**
 *
 */
class ConversationModel
{
    /**
     * @var Conversation
     */
    private Conversation $entity;

    /**
     * @var string
     */
    private string $otherParticipantName;

    /**
     * @var string|null
     */
    private ?string $otherParticipantProfilePicture;

    /**
     * @var MessageModel|null
     */
    private ?MessageModel $lastMessage;

    public function __construct(
        Conversation $conversation = null,
        string $otherParticipantName = '',
        string $otherParticipantProfilePicture = '',
        ?MessageModel $lastMessage = null
    ) {
            $this->entity = $conversation;
            $this->otherParticipantName = $otherParticipantName;
            $this->otherParticipantProfilePicture = $otherParticipantProfilePicture;
            $this->lastMessage = $lastMessage;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->entity->getId();
    }

    /**
     * @return string
     */
    public function getOtherParticipantName(): string
    {
        return $this->otherParticipantName;
    }

    /**
     * @return string
     */
    public function getOtherParticipantProfilePicture(): string
    {
        return $this->otherParticipantProfilePicture;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->entity->getCreatedAt();
    }

    /**
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {
        return $this->entity->getCreatedAt()->format('d.m');
    }

    /**
     * @return MessageModel|null
     */
    public function getLastMessage(): ?MessageModel
    {
        return $this->lastMessage;
    }
}