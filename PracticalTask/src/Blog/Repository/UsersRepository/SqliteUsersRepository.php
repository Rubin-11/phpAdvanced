<?php

namespace Rubin\LevelTwo\Blog\Repository\UsersRepository;

use PDOStatement;
use Rubin\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use Rubin\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Rubin\LevelTwo\Blog\Name;
use Rubin\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Rubin\LevelTwo\Blog\User;
use Rubin\LevelTwo\Blog\UUID;
use PDO;

class SqliteUsersRepository implements UsersRepositoryInterface
{
    public function __construct(
        private readonly PDO $connection
    )
    {
    }

    public function save(User $user): void
    {
        //Подготавливаем запрос
        //Добавили поле userName в запрос
        $statement = $this->connection->prepare(
            'INSERT INTO user (idUser, userName, first_name, last_name)
                   VALUES (:idUser, :userName, :first_name, :last_name)'
        );

        //Выполняем запрос с конкретными значениями
        $statement->execute([
            ':idUser' => (string)$user->IdUser(),
            ':userName' => $user->userName(),
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last(),

            //Это работает, потому что класс UUID
            //имеет магический метод __toString(),
            //который вызываеться, когда объект
            //приводиться к строке с помощью (string)
        ]);
    }

    //Также добавим метод для получения пользователя по его UUID

    /**
     * @throws UserNotFoundException
     */
    public function get(UUID $uuid): User
     {
        $statement = $this->connection->prepare(
            'SELECT * FROM user WHERE idUser = :idUser'
        );
        $statement->execute([
            ':idUser' => (string)$uuid,
        ]);

        return $this->getUser($statement, $uuid);
    }

    //Добавили метод получения пользователя по userName

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUsername(string $userName):User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM user WHERE userName = :userName'
        );
        $statement->execute([
            'userName' => $userName,
        ]);
        return $this->getUser($statement,$userName);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    //Вынесли общую логику в отдельный приватный метод
    private function getUser(PDOStatement $statement, string $userName)
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Бросаем исключение, если пользоватеь не найден
        if (false === $result) {
            throw new UserNotFoundException(
                "Cannot find user: $userName"
            );
        }

        //Создаем объект пользователя с полем userName
        return new User(
            new UUID($result['idUser']),
            $result['userName'],
            new Name($result['first_name'], $result['last_name'])
        );
    }
}