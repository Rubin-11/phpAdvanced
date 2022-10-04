<?php

namespace CourseProject\LevelTwo\Common;

class Name
{
    public function __construct(
        private readonly ?string $firstName,
        private readonly ?string $lastName
    ){}

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

}