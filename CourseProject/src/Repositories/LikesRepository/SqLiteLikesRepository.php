<?php

namespace CourseProject\LevelTwo\Repositories\LikesRepository;

use CourseProject\LevelTwo\Blog\Like\Like;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\LikeNotFoundException;
use PDO;
use PDOStatement;

class SqLiteLikesRepository implements LikesRepositoryInterface
{
    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Like $like): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO likes (idLike, postId, userId)
            VALUES (:idLike, :postId, :userId)'
        );
        $statement->execute([
            ':idLike'=> (string)$like->getLike(),
            ':postId'=> $like->getArticle(),
            ':userId'=> $like->getUser()
        ]);
    }

    public function get(UUID $id): Like
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE idLike = :idLike'
        );
        $statement->execute([
            ':idLike' => (string)$id,
        ]);
        return $this->getLike($statement, $id);
    }

    public function getByAuthor(UUID $id): Like
    {
        // TODO: Implement getByAuthor() method.
    }

    public function getByArticle(UUID $id): Like
    {
        // TODO: Implement getByArticle() method.
    }

    public function getAllByAuthor(UUID $id): iterable
    {
        // TODO: Implement getAllByAuthor() method.
    }

    public function getAllByArticle(UUID $id): iterable
    {
        $likes = [];

        $statement = $this->connection->prepare(
            'SELECT * FROM likes WHERE postId = :postId'
        );
        $statement->execute([
            ':postId' => (string)$id,
        ]);
        return $this->getAllLikes($statement);
    }

    /**
     * @throws LikeNotFoundException
     * @throws InvalidArgumentException
     */
    private function getLike(PDOStatement $statement, string $id): Like
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new LikeNotFoundException(
                "Cannot find like: $id"
            );
        }
        // Создаём объект пользователя с полем username
        return new Like(new UUID($result['idLike']), new UUID($result['postId']), new UUID($result['userId']));
    }

    /**
     * @throws LikeNotFoundException
     * @throws InvalidArgumentException
     */
    private function getAllLikes(PDOStatement $statement): iterable
    {
        $likes = [];
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new LikeNotFoundException(
                "Cannot find likes on this article."
            );
        }
        while ($result){
            $likes [] = new Like(new UUID($result['idLike']), new UUID($result['postId']), new UUID($result['userId']));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }

        return $likes;
    }
}