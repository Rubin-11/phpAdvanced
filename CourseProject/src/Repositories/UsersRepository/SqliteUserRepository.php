<?php

namespace CourseProject\LevelTwo\Repositories\UsersRepository;


use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;
use PDO;
use PDOStatement;

class SqliteUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly PDO $connection
    ){}

    //Метод сохранения данных в базу данных, получаем объект User
    public function save(User $user): void
    {
        //Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO user (id_user, user_name, first_name, last_name)
                   VALUES (:id_user, :user_name, :first_name, :last_name)'
        );

        $statement->execute([
            ':id_user' =>(string)$user->getIdUser(),
            ':user_name' =>$user->getUserName(),
            ':first_name'=>$user->getName()->getFirstName(),
            ':last_name'=> $user->getName()->getLastName(),
        ]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function get(UUID $idUser): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM user WHERE id_user = :id_user'
        );
        $statement->execute([
            ':id_user' => (string)$idUser
        ]);
        return $this->getUser($statement, $idUser);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function getByUserName(string $username): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM user WHERE user_name = :user_name'
        );
        $statement->execute([
            ':user_name' => $username,
        ]);
        return $this->getUser($statement, $username);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    private function getUser(PDOStatement $statement, string $userName): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if(false === $result) {
            throw new UserNotFoundException(
                "Cannot find user: $userName"
            );
        }
        return new User(
            new UUID($result['id_user']),
            $result['user_name'],
            new Name($result['first_name'], $result['last_name'])
        );
    }
}