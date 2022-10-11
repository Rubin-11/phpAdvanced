<?php

namespace CourseProject\LevelTwo\Blog\Comment;

use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\ArgumentException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepositoryInterface;

class CreateCommentCommand
{
    public function __construct(
        private readonly CommentRepositoryInterface $usersRepository
    ) {}

    /**
     * @throws ArgumentException
     * @throws InvalidArgumentException
     */
  //    public function handle(Arguments $arguments, UUID $authorId, UUID $articleId ):void{

        public function handle(Arguments $arguments):void{
        $idC = UUID::random();
        $idP = UUID::random();
        $idA = UUID::random();
        $text = $arguments->getArg('text');

        $this->usersRepository->save(new Comment($idC, $idP, $idA, $text));
    }
}
