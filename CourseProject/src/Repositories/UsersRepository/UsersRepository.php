<?php

namespace CourseProject\LevelTwo\Repositories\UsersRepository;

use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\User;

class UsersRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function save($user): void
    {
        $this->users[] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(int $id): User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
        throw new UserNotFoundException();
    }
}
