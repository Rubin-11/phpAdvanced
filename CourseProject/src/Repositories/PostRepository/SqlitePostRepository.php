<?php

namespace CourseProject\LevelTwo\Repositories\PostRepository;

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Common\UUID;
use PDO;
use PDOStatement;

class SqlitePostRepository implements PostRepositoryInterface
{
    public function __construct(
       private readonly PDO $connection
    ){}

    public function save(Post $post): void
    {
        //Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO post (id_post, author_id, title, text)
                   VALUES (:id_post, :author_id, :title, :text)'
        );

        $statement->execute([
            ':id_post' =>(string)$post->getIdPost(),
            ':author_id' =>$post->getAuthorId(),
            ':title'=>$post->getTitle(),
            ':text'=> $post->getText(),
        ]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function get(UUID $idPost): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM post WHERE id_comment = :id_post'
        );
        $statement->execute([
            ':id_post' => (string)$idPost
        ]);
        return $this->getPost($statement, $idPost);
    }

    public function getByTitle(string $title): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM post WHERE title = :title'
        );
        $statement->execute([
            ':title' => $title,
        ]);
        return $this->getPost($statement, $title);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function getByAuthor(UUID $id): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM post WHERE author_id = :author_id'
        );
        $statement->execute([
            'author_id' => (string)$id,
        ]);
        return $this->getPost($statement, $id);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    private function getPost(PDOStatement $statement, string $title): Post
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if(false === $result) {
            throw new UserNotFoundException(
                "Cannot find post: $title"
            );
        }
        return new Post(
            new UUID($result['id_post']),
            new UUID($result['author_id']),
            $result['title'],
            $result['text']
        );
    }
}