<?php
namespace src\Blog_Post;

use src\Person\Person;

class Class_Post
{
    public function __construct(
        readonly Person $author,
        readonly string $text
    ){}

    public function __toString()
    {
        return $this->author . 'пишет:' . $this->text;
    }
}