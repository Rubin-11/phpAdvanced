<?php

namespace CourseProject\LevelTwo;

class Article
{
    public function __construct(
        private int $id,
        private int $idAuthor,
        private string $heading,
        private string $text
    ){}

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
        return $argv = $this->heading . ' ' . $this->text;
    }



}