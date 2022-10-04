<?php

namespace CourseProject\LevelTwo\Blog\User;

use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;

class User
{
    public function __construct(
        private readonly ?UUID    $idUser,
        private readonly ?Name $name,
        private readonly ?string $userName,
    ){}

    public function getIdUser(): ?UUID
    {
        return $this->idUser;
    }

    public function getName(): ?Name
    {
        return $this->name;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function __toString(): string{
        return (
            "id=".$this->idUser.", "."name=".$this->name->getFirstName().
            ", "."lastname=".$this->name->getLastName().", 
            username=".$this->userName.PHP_EOL);
    }
}