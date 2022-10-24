<?php

use CourseProject\LevelTwo\Exceptions\AppException;
use CourseProject\LevelTwo\Http\Action\CommentAction\FindCommentById;
use CourseProject\LevelTwo\Http\Action\PostAction\FindPostById;
use CourseProject\LevelTwo\Http\Action\PostAction\CreatePost;
use CourseProject\LevelTwo\Http\Action\PostAction\DeletePostById;

use CourseProject\LevelTwo\Http\Action\CommentAction\CreateComment;

use CourseProject\LevelTwo\Http\Action\UserAction\CreateUser;
use CourseProject\LevelTwo\Http\Action\UserAction\FindByUsername;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Repositories\PostRepository\SqlitePostRepository;
use CourseProject\LevelTwo\Repositories\CommentRepository\SqliteCommentRepository;
use CourseProject\LevelTwo\Repositories\UsersRepository\SqliteUserRepository;
use CourseProject\LevelTwo\Exceptions\HttpException;

echo "Hello";

require_once __DIR__ . "/vendor/autoload.php";
$const = new PDO('sqlite:' . __DIR__ . '/blog_course_project.sqlite');

$request = new Request($_GET, $_SERVER, file_get_contents("php://input"));

try {
    $path = $request->path();
} catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

try {
    //  Пытаемся получить HTTP - метод запроса
    $method = $request->method();
}   catch (HttpException $e) {
    //  Возвращаем неудачный ответ,
    //  если по какой-то причине
    //  не может получить метод
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

$router = [
    //  Добавили еще один уровень вложенности
    //  для отделения маршрутов,
    //  применяемых к запросам с разными методами
    'GET' => [
        '/show/user' => new FindByUsername(
            new SqliteUserRepository($const)
        ),
        '/show/post' => new FindPostById(
            new SqlitePostRepository($const)
        ),
        '/show/comment' => new FindCommentById(
            new SqliteCommentRepository($const)
        ),
    ],

    'POST' => [
        //  Добавили новый маршрут
        '/create/user' => new CreateUser(
            new SqliteUserRepository($const)
        ),
        '/create/post' => new CreatePost(
            new SqlitePostRepository($const)
        ),
        '/create/comment' => new CreateComment(
            new SqliteCommentRepository($const)
        )
    ],

    'DELETE' => [
        '/delete/post' => new DeletePostById(
            new SqlitePostRepository($const)
        )
    ]
];

//  Если у нас нет маршоутов для метода запроса -
//  возвращаем неуспешный ответ
if (!array_key_exists($method, $router)) {
    (new ErrorResponse('Net hod Not found'))->send();
    return;
}

//  Ищем маршрут среди маршрутов для этого метода
if (!array_key_exists($path, $router[$method])) {
    (new ErrorResponse('Router Not found'))->send();
    return;
}

//  Выбираем действие по методу и пути
$action = $router[$method][$path];

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();