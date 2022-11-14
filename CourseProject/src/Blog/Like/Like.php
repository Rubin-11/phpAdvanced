<?php

namespace CourseProject\LevelTwo\Blog\Like;

use CourseProject\LevelTwo\Common\UUID;

class Like
{
    private UUID $idLike;
    private UUID $postId;
    private UUID $userId;

    public function __construct(UUID $idLike, UUID $postId, UUID $userId)
    {
        $this->idLike = $idLike;
        $this->postId = $postId;
        $this->userId = $userId;
    }

    /**
     * @return UUID
     */
    public function getIdLike(): UUID
    {
        return $this->idLike;
    }

    /**
     * @param UUID $idLike
     */
    public function setIdLike(UUID $idLike): void
    {
        $this->idLike = $idLike;
    }

    /**
     * @return UUID
     */
    public function getPostId(): UUID
    {
        return $this->postId;
    }

    /**
     * @param UUID $postId
     */
    public function setPostId(UUID $postId): void
    {
        $this->postId = $postId;
    }

    /**
     * @return UUID
     */
    public function getUserId(): UUID
    {
        return $this->userId;
    }

    /**
     * @param UUID $userId
     */
    public function setUserId(UUID $userId): void
    {
        $this->userId = $userId;
    }

    public function __toString(): string{
        return ("idLike=".$this->idLike.", "."articleId=".$this->postId.", "."userId=".$this->userId.PHP_EOL);
    }
}