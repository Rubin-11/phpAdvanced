<?php

namespace CourseProject\LevelTwo\Http\Action\UserAction;

use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

class FindByUsername implements ActionInterface
{
    //  Нам понадобиться репозиторий пользователей,
    //  внедряем его контракт в качестве зависимости
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    //  Функция, описанная в контракте
    public function handle(Request $request): Response
    {
        try {
            //  Пытаемся получить искомое имя пользователя из запроса
            $username = $request->query('user_name');
        } catch (HttpException $e) {
            //  Если в запросе нет параметра username -
            //  возвращаем неуспешный ответ,
            //  сообщение об ошибке берем из описания исключения
            return new ErrorResponse($e->getMessage());
        }
        try {
            //  Пытаемся найти пользователя в репозитории
            $user = $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException $e) {
            //  Если пользователь не найден -
            //  возвращаем неуспешный ответ
            return new ErrorResponse($e->getMessage());
        }
        //  Возвращаем неуспешный ответ
        return new SuccessResponse([
            'username' => $user->getUsername(),
            'name' => $user->getName()->getFirstName() . ' ' . $user->getName()->getLastName(),
        ]);
    }
}