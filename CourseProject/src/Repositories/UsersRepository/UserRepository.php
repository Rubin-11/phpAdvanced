<?php

namespace CourseProject\LevelTwo\Repositories\UsersRepository;

use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\User;
use CourseProject\LevelTwo\UUID;

class UserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function save($user): void
    {
        $this->users[] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(UUID $idUser): User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $idUser) {
                return $user;
            }
        }
        throw new UserNotFoundException();
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username): User
    {
        foreach ($this->users as $user) {
            if ($user->username() === $username) {
                return $user;
            }
        }
        throw new UserNotFoundException("User not found: $username");

    }
}
