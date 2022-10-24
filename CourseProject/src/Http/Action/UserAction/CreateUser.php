<?php

namespace CourseProject\LevelTwo\Http\Action\UserAction;

use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

class CreateUser implements ActionInterface
{
    //  Нам понадобиться репозиторий пользователей,
    //  внедряем его контракт в качестве зависимости
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        $id = UUID::random();
        try {
            $first_name = $request->jsonBodyField('first_name');
            $username = $request->jsonBodyField('user_name');
            $last_name = $request->jsonBodyField('last_name');
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->userRepository->save(new User(
            $id,
            new Name($first_name, $last_name),
            $username
        ));

        return new SuccessResponse([
            "message" => "User successful create with Id=$id",
        ]);
    }
}