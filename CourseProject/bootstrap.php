<?php

use CourseProject\LevelTwo\Blog\Container\DIContainer;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepositoryInterface;
use CourseProject\LevelTwo\Repositories\CommentRepository\SqliteCommentRepository;
use CourseProject\LevelTwo\Repositories\LikesRepository\LikesRepositoryInterface;
use CourseProject\LevelTwo\Repositories\LikesRepository\SqLiteLikesRepository;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;
use CourseProject\LevelTwo\Repositories\UsersRepository\SqliteUserRepository;
use CourseProject\LevelTwo\Repositories\PostRepository\SqlitePostRepository;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

// Подключаем авто-загрузчик Composer
require_once __DIR__ . '/vendor/autoload.php';

// Создаём объект контейнера ..
$container = new DIContainer();

// .. и настраиваем его:

// 1. подключение к БД
$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/blog_course_project.sqlite')
);

// 2. репозиторий статей
$container->bind(
    PostRepositoryInterface::class,
    SqlitePostRepository::class
);

// 3. репозиторий пользователей
$container->bind(
    UserRepositoryInterface::class,
    SqliteUserRepository::class
);

// 4. репозиторий комментарий
$container->bind(
    CommentRepositoryInterface::class,
    SqliteCommentRepository::class
);
// 5. репозиторий лайков
$container->bind(
    LikesRepositoryInterface::class,
    SqLiteLikesRepository::class
);

// Возвращаем объект контейнера
return $container;
