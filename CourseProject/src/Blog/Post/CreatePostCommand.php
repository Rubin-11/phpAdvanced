<?php

namespace CourseProject\LevelTwo\Blog\Post;

use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\ArgumentException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;


class CreatePostCommand
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    /**
     * @throws ArgumentException
     * @throws InvalidArgumentException
     */
    public function handle(Arguments $arguments):void{
        $id = UUID::random();
        $idAuthor = UUID::random();
        $title = $arguments->getArg('title');
        $text = $arguments->getArg('text');

        $this->postRepository->save(new Post($id,$idAuthor, $title, $text));
    }
}