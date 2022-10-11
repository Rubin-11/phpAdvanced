<?php

use CourseProject\LevelTwo\Blog\Post\CreatePostCommand;
use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;
use PHPUnit\Framework\TestCase;

class PostCommandClassTest extends TestCase
{
    private function getRepo(): PostRepositoryInterface
    {
        return new class implements PostRepositoryInterface {
            private bool $callback = false;
            public function save(Post $post): void
            {
                $this->callback = true;
            }


            public function getCallback(): bool
            {
                return $this->callback;
            }

            public function getByTitle(string $title): Post
            {
                // TODO: Implement getByTitle() method.
            }

            public function getByAuthor(UUID $id): Post
            {
                // TODO: Implement getByAuthor() method.
            }

            public function get(UUID $idPost): Post
            {
                // TODO: Implement get() method.
            }
        };
    }


    public function testItSavesUserToRepository():void{

        $obj = $this->getRepo();

        $userCom = new CreatePostCommand($obj);

        $userCom->handle(
            new Arguments([
                'title' => 'title',
                'text' => 'text'
            ]),
            new UUID('123e4567-e89b-12d3-a456-426614174001'));

        $this->assertTrue($obj->getCallback());
    }
}