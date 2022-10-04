<?php

namespace CourseProject\LevelTwo\Blog\Comment;

use CourseProject\LevelTwo\Common\UUID;

class Comment
{
    public function __construct(
        private readonly ?UUID $idComment,
        private readonly ?UUID $postId,
        private readonly ?UUID $authorId,
        private readonly ?string $text
    )
    {
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