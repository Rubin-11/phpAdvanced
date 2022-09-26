<?php

namespace CourseProject\LevelTwo\Repositories\CommentRepository;

use CourseProject\LevelTwo\Comment;
use CourseProject\LevelTwo\Exceptions\CommentNotFoundException;

class CommentRepository implements CommentRepositoryInterface
{
    private array $comments = [];

    public function save($comment):void
    {
        $this->comments[] = $comment;
    }


    /**
     * @throws CommentNotFoundException
     */
    public function get(int $id):Comment
    {
        foreach ($this->comments as $comment) {
            if($comment->getId() === $id) {
                return $comment;
            }
        }
        throw new CommentNotFoundException();
    }
}