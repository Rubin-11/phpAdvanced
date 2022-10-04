<?php

namespace CourseProject\LevelTwo\Blog\Post;

use CourseProject\LevelTwo\Common\UUID;

class Post
{
    public function __construct(
        private readonly ?UUID   $idPost,
        private readonly ?UUID   $authorId,
        private readonly ?string $title,
        private readonly ?string $text
    ){}

    public function getIdPost(): ?UUID
    {
        return $this->idPost;
    }

    public function getAuthorId(): ?UUID
    {
        return $this->authorId;
    }

        public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function __toString():string
    {
        return (
            "id=".$this->idPost.", "."authorId=".$this->authorId.",
            "."title=".$this->title.", "."text=".$this->text.PHP_EOL
        );
    }
}