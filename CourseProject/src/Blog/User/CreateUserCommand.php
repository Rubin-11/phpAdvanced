<?php

namespace CourseProject\LevelTwo\Blog\User;

use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Exceptions\ArgumentException;
use CourseProject\LevelTwo\Exceptions\CommandException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;
use CourseProject\LevelTwo\Common\UUID;


class CreateUserCommand
{
    public function __construct(
        private readonly UserRepositoryInterface $usersRepository
    ) {}

    /**
     * @throws ArgumentException
     * @throws InvalidArgumentException
     * @throws CommandException
     */
    public function handle(Arguments $arguments):void{
        $id = UUID::random();
        $name = new Name($arguments->getArg('first_name'), $arguments->getArg('last_name'));
        $username = $arguments->getArg('user_name');

        if($this->UserExist($username)){
            throw new CommandException("User already exists: $username");
        }

        $this->usersRepository->save(new User($id, $name, $username));
    }

    public function UserExist($username):bool{
        try {
            $user = $this->usersRepository->getByUsername($username);
        }catch (UserNotFoundException $e){
            return false;
        }
        return true;
    }
}