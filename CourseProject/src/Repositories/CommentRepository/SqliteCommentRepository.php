<?php

namespace CourseProject\LevelTwo\Repositories\CommentRepository;

use CourseProject\LevelTwo\Blog\Comment\Comment;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Common\UUID;
use PDO;
use PDOStatement;

class SqliteCommentRepository implements CommentRepositoryInterface
{
    public function __construct(
        private readonly PDO $connection
    ){}

    public function save(Comment $comment): void
    {
        //Подготавливаем запрос
        $statement = $this->connection->prepare(
            'INSERT INTO comment (id_comment, post_id, author_id, text)
                   VALUES (:id_comment, :post_id, :author_id, :text)'
        );

        $statement->execute([
            ':id_comment' =>(string)$comment->getIdComment(),
            ':post_id' =>$comment->getPostId(),
            ':author_id'=>$comment->getAuthorId(),
            ':text'=> $comment->getText(),
        ]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function get(UUID $idComment): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comment WHERE id_comment = :id_comment'
        );
        $statement->execute([
            ':id_comment' => (string)$idComment
        ]);
        return $this->getComment($statement, $idComment);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    private function getByAuthor(UUID $id): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comment WHERE author_id = :id_author'
        );
        $statement->execute([
            ':idAuthor' => (string)$id,
        ]);
        return $this->getComment($statement, "by authorId".$id);
    }

    /**
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    private function getByPost(UUID $id): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comment WHERE post_id = :id_post'
        );
        $statement->execute([
            'post_id' => (string)$id,
        ]);
        return $this->getComment($statement, "by postId" . $id);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    private function getComment(PDOStatement $statement, string $id): Comment
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if(false === $result) {
            throw new UserNotFoundException();
        }
        return new Comment(
            new UUID($result['id_comment']),
            new UUID($result['post_id']),
            new UUID($result['author_id']),
            $result['text']
        );
    }
}