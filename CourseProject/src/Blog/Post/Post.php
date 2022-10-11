<?php

namespace CourseProject\LevelTwo\Blog\Post;

use CourseProject\LevelTwo\Common\UUID;

class Post
{
    public function __construct(
        private ?UUID   $idPost,
        private ?UUID   $authorId,
        private ?string $title,
        private ?string $text
    ){}

    /**
     * @param UUID|null $authorId
     */
    public function setAuthorId(?UUID $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param UUID|null $idPost
     */
    public function setIdPost(?UUID $idPost): void
    {
        $this->idPost = $idPost;
    }

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
            "id=".$this->idPost.", "."authorId=".$this->authorId.", "."title=".$this->title.", "."text=".$this->text.PHP_EOL
        );
    }
}