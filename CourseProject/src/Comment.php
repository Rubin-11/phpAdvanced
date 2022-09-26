<?php

namespace CourseProject\LevelTwo;

class Comment
{
    public function __construct(
        private int    $id,
        private int    $idAuthor,
        private int    $idArticle,
        private string $text
    )
    {
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getIdAuthor(): int
    {
        return $this->idAuthor;
    }

    public function __toString():string
    {
        return $argv = $this->text;
    }

    /**
     * @return int
     */
    public function getIdArticle(): int
    {
        return $this->idArticle;
    }
}