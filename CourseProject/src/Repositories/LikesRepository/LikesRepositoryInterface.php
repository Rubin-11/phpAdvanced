<?php

namespace CourseProject\LevelTwo\Repositories\LikesRepository;

use CourseProject\LevelTwo\Blog\Like\Like;
use CourseProject\LevelTwo\Common\UUID;

interface LikesRepositoryInterface
{
    public function save(Like $comment): void;
    public function get(UUID $uuid): Like;
    public function getByAuthor(UUID $id): Like;
    public function getByArticle(UUID $id): Like;
    public function getAllByAuthor(UUID $id): iterable;
    public function getAllByArticle(UUID $id):iterable;
}