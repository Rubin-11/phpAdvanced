<?php

use CourseProject\LevelTwo\Blog\Comment\Comment;
use CourseProject\LevelTwo\Blog\Comment\CreateCommentCommand;
use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CommentCommandClassTest extends TestCase
{
    private function getRepo(): CommentRepositoryInterface
    {
        return new class implements  CommentRepositoryInterface {
            private bool $callback = false;
            public function save(Comment $comment): void
            {
                $this->callback = true;
            }


            public function getCallback(): bool
            {
                return $this->callback;
            }

            public function get(UUID $idComment): Comment
            {
                // TODO: Implement get() method.
            }

            public function getByAuthor(UUID $idAuthor): Comment
            {
                // TODO: Implement getByAuthor() method.
            }

            public function getByPost(UUID $idPost): Comment
            {
                // TODO: Implement getByArticle() method.
            }
        };
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\ArgumentException
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
    public function testItSavesUserToRepository():void{

        $obj = $this->getRepo();

        $userCom = new CreateCommentCommand($obj);

        $userCom->handle(
            new Arguments([
                'title' => 'title',
                'text' => 'text'
            ]),
            new UUID('123e4567-e89b-12d3-a456-426614174001'), new UUID('123e4567-e89b-12d3-a456-426614174002'));

        $this->assertTrue($obj->getCallback());
    }
}