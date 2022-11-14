<?php

use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Blog\User\CreateUserCommand;
use CourseProject\LevelTwo\Exceptions\AppException;

// Подключаем файл bootstrap.php
// и получаем настроенный контейнер
$container = require __DIR__ . '/bootstrap.php';

// При помощи контейнера создаём команду
$command = $container->get(CreateUserCommand::class);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (AppException $e) {
    echo "{$e->getMessage()}\n";
}