<?php

namespace CourseProject\LevelTwo\Http\Action\CommentAction;

use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\CommentNotFoundException;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepositoryInterface;

class FindCommentById implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $id = $request->query('id');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }
        try {
            $comment = $this->commentRepository->get(new UUID($id));
        } catch (CommentNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }
        return new SuccessResponse([
            'id_user' => (string)$comment->getIdComment(),
            'author_id' => (string)$comment->getAuthorId(),
            'post_id' => (string)$comment->getPostId(),
        ]);
    }

}