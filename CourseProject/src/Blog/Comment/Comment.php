<?php

namespace CourseProject\LevelTwo\Blog\Comment;

use CourseProject\LevelTwo\Common\UUID;

class Comment
{
    public function __construct(
        private  ?UUID $idComment,
        private  ?UUID $authorId,
        private  ?UUID $postId,
        private  ?string $text
    )
    {
    }

    /**
     * @param UUID|null $idComment
     */
    public function setIdComment(?UUID $idComment): void
    {
        $this->idComment = $idComment;
    }

    /**
     * @param UUID|null $postId
     */
    public function setPostId(?UUID $postId): void
    {
        $this->postId = $postId;
    }

    /**
     * @param UUID|null $authorId
     */
    public function setAuthorId(?UUID $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getIdComment(): ?UUID
    {
        return $this->idComment;
    }

    public function getPostId(): ?UUID
    {
        return $this->postId;
    }

    public function getAuthorId(): ?UUID
    {
        return $this->authorId;
    }
    public function __toString():string
    {
        return ("id=".$this->idComment.", "."authorId=".$this->authorId.", "."postId=".$this->postId.", "."text=".$this->text.PHP_EOL);
    }
}