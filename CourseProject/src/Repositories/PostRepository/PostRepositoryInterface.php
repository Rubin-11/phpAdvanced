<?php

namespace CourseProject\LevelTwo\Repositories\PostRepository;

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Common\UUID;

interface PostRepositoryInterface
{
    public function save(Post $post):void;
    public function get(UUID $idPost):Post;
    public function getByTitle(string $title): Post;
    public function getByAuthor(UUID $id): Post;
}