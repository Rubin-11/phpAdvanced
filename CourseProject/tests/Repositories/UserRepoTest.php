<?php

use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Repositories\UsersRepository\SqliteUserRepository;
use PHPUnit\Framework\TestCase;

class UserRepoTest extends TestCase
{
    public function testItSavesUserToDatabase(): void
    {
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);


        $statementMock
            ->expects($this->once())
            ->method('execute')
            ->with([
            // Даём понять что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
            ':id_user' => '123e4567-e89b-12d3-a456-426614174000',
            ':user_name' => 'ivan123',
            ':first_name' => 'Ivan',
            ':last_name' => 'Niki-tin',
        ])->willReturn(true);

        $connectionMock->method("prepare")->willReturn($statementMock);

        $sqlRepo = new SqliteUserRepository($connectionMock);
        // Свойства пользователя точно такие,как и в описании мока
        $sqlRepo->save(new User(
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                new Name('Ivan', 'Niki-tin'),
                'ivan123'
            )
        );
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
    public function testExceptionWhenUserNotFound(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with(
            [ // Даём понятьь что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
                ':id_user' => '123e4567-e89b-12d3-a456-426614174000']
        );
        $statementMock->method('fetch')->willReturn(false);

        $sqlRepo=new SqliteUserRepository($connectionMock);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("Cannot find user: 123e4567-e89b-12d3-a456-426614174000");

        $sqlRepo->get(new UUID('123e4567-e89b-12d3-a456-426614174000'));
    }


    /**
     * @throws UserNotFoundException
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
//    public function testGetUserByUserName(){
//        $connectionMock = $this->createStub(PDO::class);
//        $statementMock = $this->createStub(PDOStatement::class);
//
//        $connectionMock->method('prepare')->willReturn($statementMock);
//
//        $statementMock->expects($this->once())->method('execute')->with(
//            [ // Даём понять что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
//                ':user_name' => 'ivan228'
//            ]
//        );
//        $statementMock->method('fetch')->willReturn([
//            'id_user'=>'123e4567-e89b-12d3-a456-426614174000',
//            'first_name'=>'Ivan',
//            'last_name'=> 'Nikitin',
//            ':user_name'=>'ivan228',
//        ]);
//
//        $sqlRepo=new SqliteUserRepository($connectionMock);
//
//        $user = new User(new UUID(
//            '123e4567-e89b-12d3-a456-426614174000'),
//            new Name('Ivan', 'Nikitin'),
//            'ivan228',
//        );
//
//        $value = $sqlRepo->getByUserName('ivan228');
//
//        $this->assertEquals($user, $value);
//    }
}