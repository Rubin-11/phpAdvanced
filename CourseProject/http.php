<?php

use CourseProject\LevelTwo\Exceptions\AppException;
use CourseProject\LevelTwo\Http\Action\CommentAction\CreateComment;
use CourseProject\LevelTwo\Http\Action\CommentAction\FindCommentById;
use CourseProject\LevelTwo\Http\Action\LikeAction\CreateLike;
use CourseProject\LevelTwo\Http\Action\LikeAction\FindLikesByArticle;
use CourseProject\LevelTwo\Http\Action\PostAction\CreatePost;
use CourseProject\LevelTwo\Http\Action\PostAction\DeletePostById;
use CourseProject\LevelTwo\Http\Action\PostAction\FindPostById;
use CourseProject\LevelTwo\Http\Action\UserAction\CreateUser;
use CourseProject\LevelTwo\Http\Action\UserAction\FindByUsername;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;

http_response_code(200);

// Подключаем файл bootstrap.php
// и получаем настроенный контейнер
$container = require __DIR__ . '/bootstrap.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input'));

try {
    $path = $request->path();
} catch (\CourseProject\LevelTwo\Exceptions\HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

try {
    // Пытаемся получить HTTP-метод запроса
    $method = $request->method();





} catch (\CourseProject\LevelTwo\Exceptions\HttpException $exception) {
    // Возвращаем неудачный ответ,
    // если по какой-то причине
    // не можем получить метод
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

$routes = [
    'GET' => [
        '/show/user' => FindByUsername::class,
        '/show/posts' => FindPostById::class,
        '/show/comment' => FindCommentById::class,
        '/show/postLikes' => FindLikesByArticle::class,
    ],
    'POST' => [
        '/create/user' => CreateUser::class,
        '/create/posts' => CreatePost::class,
        '/create/comment' => CreateComment::class,
        '/create/like' => CreateLike::class,
    ],
    'DELETE' => [
        '/delete/article' => DeletePostById::class
    ]
];

// Если у нас нет маршрутов для метода запроса -
// возвращаем неуспешный ответ
if (!array_key_exists($method, $routes)) {
    (new ErrorResponse("Method not found: $method $path"))->send();
    return;
}

// Ищем маршрут среди маршрутов для этого метода
if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

// Получаем имя класса действия для маршрута
$actionClassName = $routes[$method][$path];

// С помощью контейнера
// создаём объект нужного действия
$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
}
$response->send();