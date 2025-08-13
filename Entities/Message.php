<?php

/**
 *
 */
class Message extends AbstractEntity
{
    /**
     * @var int
     */
    protected int $conversationId;

    /**
     * @var int
     */
    protected int $senderId;

    /**
     * @var string
     */
    protected string $content;

    /**
     * @var DateTime
     */
    protected DateTime $sentAt;

    /**
     * @var bool
     */
    protected bool $isRead;

    /**
     * @return int
     */
    public function getConversationId(): int
    {
        return $this->conversationId;
    }

    /**
     * @param int $conversationId
     * @return void
     */
    public function setConversationId(int $conversationId): void
    {
        $this->conversationId = $conversationId;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * @param int $senderId
     * @return void
     */
    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return DateTime
     */
    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }

    /**
     * @param string|DateTime $sentAt
     * @return void
     * @throws Exception
     */
    public function setSentAt(string|DateTime $sentAt): void
    {
        if (is_string($sentAt)) {
            $sentAt = new DateTime($sentAt);
        }
        $this->sentAt = $sentAt;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     * @return void
     */
    public function setIsRead(bool $isRead): void
    {
        $this->isRead = $isRead;
    }
}