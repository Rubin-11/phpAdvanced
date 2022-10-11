<?php

namespace Rubin\LevelTwo\Blog\Commands;

//use MongoDB\Driver\Exception\CommandException;
use Rubin\LevelTwo\Blog\Exceptions\CommandException;
use Rubin\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use Rubin\LevelTwo\Blog\Name;
use Rubin\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Rubin\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Rubin\LevelTwo\Blog\User;
use Rubin\LevelTwo\Blog\UUID;

class CreateUserCommand
{
    //Команда зависит от контрактра репозитория пользователей,
    //а не от конкретной реализации
    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository
    ){}
    //Вместо массива принимаем объект типа Arguments

    /**
     * @throws InvalidArgumentException
     * @throws CommandException
     */
    public function handle(Arguments $arguments): void
    {
//        $input = $this->parseRawInput($rawInput);

        $userNane = $arguments->get('userName');

        //Проверяем, существует ли пользователь в репозитории
        if ($this->userExists($userNane)) {
            //Бросаем исключение, если пользователь уже существует
            throw new CommandException("User already exists: $userNane");
        }

        //Сохраняем пользователя в репозиторий
        $this->usersRepository->save(new User(
            UUID::random(),
            $userNane,
            new Name($arguments->get('first_name'), $arguments->get('last_name'))
        ));
    }

    private function userExists(string $userName): bool
    {
        try {
            //Пытаемся получить пользователей из репозитория
            $this->usersRepository->getByUsername($userName);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }
}