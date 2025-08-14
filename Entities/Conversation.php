<?php

class Conversation extends AbstractEntity
{
    /**
     * @var int
     */
    protected int $participantOneId;

    /**
     * @var int
     */
    protected int $participantTwoId;

    /**
     * @var DateTime
     */
    protected DateTime $createdAt;

    /**
     * @return int
     */
    public function getParticipantOneId(): int
    {
        return $this->participantOneId;
    }

    /**
     * @param int $participantOneId
     * @return void
     */
    public function setParticipantOneId(int $participantOneId): void
    {
        $this->participantOneId = $participantOneId;
    }

    /**
     * @return int
     */
    public function getParticipantTwoId(): int
    {
        return $this->participantTwoId;
    }

    /**
     * @param int $participantTwoId
     * @return void
     */
    public function setParticipantTwoId(int $participantTwoId): void
    {
        $this->participantTwoId = $participantTwoId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string|DateTime $createdAt
     * @return void
     * @throws Exception
     */
    public function setCreatedAt(string|DateTime $createdAt): void
    {
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
    }

    public function hasParticipant(int $userId): bool
    {
        return $userId === $this->participantOneId || $userId === $this->participantTwoId;
    }
}
