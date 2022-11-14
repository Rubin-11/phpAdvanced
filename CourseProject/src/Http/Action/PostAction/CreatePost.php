<?php

namespace CourseProject\LevelTwo\Http\Action\PostAction;

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepository;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly ?UserRepositoryInterface $userRepository = null
    ){}

    public function handle(Request $request): Response
    {
        $id = UUID::random();

        try {
            $authorId = new UUID($request->jsonBodyField('author_id'));
            $title = $request->jsonBodyField('title');
            $text = $request->jsonBodyField('text');
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->userRepository->get($authorId);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->postRepository->save(new Post(
            $id,
            $authorId,
            $title,
            $text
        ));

        return new SuccessResponse([
            "message" => "Article successful create with Id=$id"
        ]);
    }
}