<?php

use CourseProject\LevelTwo\Blog\User\CreateUserCommand;
use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\ArgumentException;
use CourseProject\LevelTwo\Exceptions\CommandException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use PHPUnit\Framework\TestCase;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

class UserCommandClassTest extends TestCase
{
    private function getRepo(): UserRepositoryInterface
    {
        return new class implements UserRepositoryInterface {
            private bool $callback = false;
            public function save(User $user): void
            {
                $this->callback = true;
            }

            public function get(UUID $idUser): User
            {
                throw new UserNotFoundException("Not found");
            }

            public function getByUsername(string $username): User
            {
                throw new UserNotFoundException("Not found");
            }

            public function getCallback(): bool
            {
                return $this->callback;
            }
        };
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws ArgumentException
     * @throws CommandException
     */
    public function testItSavesUserToRepository():void{

        $obj = $this->getRepo();

        $userCom = new CreateUserCommand($obj);

        $userCom->handle(new Arguments([
            'user_name' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Nikitin',
        ]));

        $this->assertTrue($obj->getCallback());
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws ArgumentException
     */
    public function testExceptionWhenUserExist():void{
        $userRepo = new class implements UserRepositoryInterface {
            public function save(User $user): void
            {
            }

            public function get(UUID $idUser): User
            {
                return new User(
                    new UUID('123e4567-e89b-12d3-a456-426614174000'),
                    new Name('Ivan', 'Nikitin'),
                    'ivan228',
                );
            }

            public function getByUsername(string $username): User
            {
                return new User(
                    new UUID('123e4567-e89b-12d3-a456-426614174000'),
                    new Name('Ivan', 'Nikitin'),
                    'ivan228',
                );
            }
        };

        $userCommand = new CreateUserCommand($userRepo);

        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("User already exists: ivan228");

        $userCommand->handle(new Arguments([
            'user_name' => 'ivan228',
            'first_name' => 'Ivan',
            'last_name' => 'Nikitin',
        ]));
    }
}