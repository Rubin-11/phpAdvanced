<?php

namespace CourseProject\LevelTwo\Repositories\CommentRepository;

use CourseProject\LevelTwo\Comment;

interface CommentRepositoryInterface
{
    public function save($comment):void;
    public function get(int $id):Comment;
}