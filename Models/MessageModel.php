<?php

/**
 *
 */
class MessageModel
{
    /**
     * @var Message
     */
    private Message $entity;
    /**
     * @var string
     */
    private string $senderName;
    /**
     * @var bool
     */
    private bool $isMine = false;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->entity = $message;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     * @return void
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return bool
     */
    public function getIsMine(): bool
    {
        return $this->isMine;
    }

    /**
     * @param bool $isMine
     * @return void
     */
    public function setIsMine(bool $isMine): void
    {
        $this->isMine = $isMine;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->entity->getContent();
    }

    /**
     * @return DateTime
     */
    public function getSentAt(): DateTime
    {
        return $this->entity->getSentAt();
    }

    public function getFormattedSentAt(): string
    {
        return $this->entity->getSentAt()->format('m.d H:i');
    }
}