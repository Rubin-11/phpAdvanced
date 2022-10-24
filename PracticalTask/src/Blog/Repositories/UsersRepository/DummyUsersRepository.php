<?php

namespace Rubin\LevelTwo\Blog\Repositories\UsersRepository;

//use Rubin\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Rubin\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use Rubin\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Rubin\LevelTwo\Blog\Name;
use Rubin\LevelTwo\Blog\User;
use Rubin\LevelTwo\Blog\UUID;

class DummyUsersRepository implements UsersRepositoryInterface
{
    public function save(User $user): void
    {
    // Ничего не делаем
    }

    public function get(UUID $uuid): User
    {
    // И здесь ничего не делаем
        throw new UserNotFoundException("Not found");
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getByUsername(string $userName): User
    {
    // Нас интересует реализация только этого метода
    // Для нашего теста не важно, что это будет за пользователь,
    // поэтому возвращаем совершенно произвольного
        return new User(UUID::random(), "user123", new Name("first", "last"));
    }
}