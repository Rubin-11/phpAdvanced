<?php

namespace CourseProject\LevelTwo;

class User
{
    public function __construct(
        private int    $id,
        private string $firstName,
        private string $lastName
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $argv = $this->firstName . ' ' . $this->lastName;
    }
}