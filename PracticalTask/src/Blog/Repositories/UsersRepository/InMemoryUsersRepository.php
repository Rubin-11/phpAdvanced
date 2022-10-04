<?php

namespace Rubin\LevelTwo\Blog\Repositories\UsersRepository;

use Rubin\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Rubin\LevelTwo\Blog\User;
use Rubin\LevelTwo\Blog\UUID;

class InMemoryUsersRepository implements UsersRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    //Заменили int на UUID
    public function get(UUID $idUser): User
    {
        foreach ($this->users as $user) {
            if ($user->IdUser() === (string)$idUser) {
                return $user;
            }
        }
        throw new UserNotFoundException();
    }

    //Добавили метод получения пользователя по userName

    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $userName):User
    {
        foreach ($this->users as $user) {
            if ($user->userName() === $userName) {
                return $user;
            }
        }
        throw new UserNotFoundException();
    }
}