<?php

namespace CourseProject\LevelTwo\Http\Action\CommentAction;

use CourseProject\LevelTwo\Blog\Comment\Comment;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepositoryInterface;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ){}

    /**
     * @throws InvalidArgumentException
     */
    public function handle(Request $request): Response
    {
        $id = UUID::random();
        try {
            $authorId = $request->jsonBodyField('author_id');
            $postId = $request->jsonBodyField('post_id');
            $text = $request->jsonBodyField('text');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->commentRepository->save(new Comment(
            $id,
            new UUID($authorId),
            new UUID($postId),
            $text
        ));

        return new SuccessResponse(["massage" => "Comment successful created with Id=$id"]);
    }
}