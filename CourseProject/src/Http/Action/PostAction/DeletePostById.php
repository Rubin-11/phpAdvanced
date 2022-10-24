<?php

namespace CourseProject\LevelTwo\Http\Action\PostAction;

use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;

class DeletePostById implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ){}

    public function handle(Request $request): Response
    {
        try {
            $id = $request->query('id_post');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->postRepository->deliteById(new UUID($id));

        return new SuccessResponse([
            "message" => "article successful delete"
        ]);
    }
}