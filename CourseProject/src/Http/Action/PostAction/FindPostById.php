<?php

namespace CourseProject\LevelTwo\Http\Action\PostAction;

use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;

class FindPostById implements ActionInterface
{
    // Нам понадобится репозиторий пользователей,
    // внедряем его контракт в качестве зависимости
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    public function handle(Request $request): Response
    {
        try{
            $id = $request->query('id');
        }catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        try{
            $post = $this->postRepository->get(new UUID($id));
        }catch (PostNotFoundException|InvalidArgumentException $e){
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            "id_post"=> (string)$post->getIdPost(),
            "author_id"=> (string)$post->getAuthorId(),
            "title"=> $post->getTitle(),
            "text"=> $post->getText()
        ]);
    }
}