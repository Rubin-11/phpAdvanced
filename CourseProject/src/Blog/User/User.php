<?php

namespace CourseProject\LevelTwo\Blog\User;

use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;

class User
{
    public function __construct(
        private  ?UUID   $idUser,
        private  ?Name $name,
        private  ?string $userName,
    )
    {
    }

    /**
     * @param Name|null $name
     */
    public function setName(?Name $name): void
    {
        $this->name = $name;
    }

    /**
     * @param UUID|null $idUser
     */
    public function setIdUser(?UUID $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param string|null $userName
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

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

    public function __toString(): string
    {
        return (
            "id=" . $this->idUser . ", " . "name=" . $this->name->getFirstName() .
            ", " . "lastname=" . $this->name->getLastName() . ", username=" . $this->userName . PHP_EOL);
    }
}