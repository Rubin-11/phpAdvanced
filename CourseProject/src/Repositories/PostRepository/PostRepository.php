<?php

namespace CourseProject\LevelTwo\Repositories\PostRepository;

use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Post;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\UUID;

class PostRepository implements PostRepositoryInterface
{
    private array $posts = [];

    public function save($post):void
    {
        $this->posts[] = $post;
    }

    /**
     * @throws PostNotFoundException
     */
    public function get(UUID $idPost):Post
    {
        foreach ($this->posts as $post) {
            if($post->getId() === $idPost) {
                return $post;
            }
        }
        throw new PostNotFoundException();
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByTitle(string $title): Post
    {
        foreach ($this->posts as $post) {
            if ($post->getArticle() === $title) {
                return $post;
            }
        }
        throw new UserNotFoundException("User not found: $title");
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByAuthor(UUID $id): Post
    {
        foreach ($this->posts as $post) {
            if ((string)$post->getAuthorId() === (string)$id) {
                return $post;
            }
        }
        throw new UserNotFoundException("User not found: $id");
    }
}