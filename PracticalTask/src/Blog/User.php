<?php

namespace Rubin\LevelTwo\Blog;

class User
{
    public function __construct(
        private readonly UUID $idUser,
        private string $userName,
        private readonly Name $name,
    ){}

    /**
     * @return string
     */
    public function userName(): string
    {
        return $this->userName;
    }

    /**
     * @return UUID
     */
    public function IdUser(): UUID
    {
        return $this->idUser;
    }

    public function name(): Name
    {
        return $this->name;
    }
}