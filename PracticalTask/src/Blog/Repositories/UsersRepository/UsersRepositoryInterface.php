<?php

namespace Rubin\LevelTwo\Blog\Repositories\UsersRepository;

use Rubin\LevelTwo\Blog\User;
use Rubin\LevelTwo\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user): void;
    public function get(UUID $idUser): User;
    public  function getByUsername(string $userName);
}