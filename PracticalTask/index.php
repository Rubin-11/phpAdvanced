<?php

use MongoDB\Driver\Exception\CommandException;
use Rubin\LevelTwo\Blog\Commands\Arguments;
use Rubin\LevelTwo\Blog\Commands\CreateUserCommand;
use Rubin\LevelTwo\Blog\Repository\UsersRepository\SqliteUsersRepository;
//use Rubin\LevelTwo\Blog\Repositories\UserRepository\InMemoryUsersRepository;


require_once __DIR__ . '/vendor/autoload.php';

//Создаем объект подключения к SQLite
//$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

//Создаем объект SQLite репозитория
$usersRepository = new SqliteUsersRepository(
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
);

// In-memory-репозиторий тоже подойдёт
// $usersRepository = new InMemoryUsersRepository();
// Команда зависит от контракта репозитория пользователей,
// так что мы передаём объект класса,
// реализующего этот контракт
$command = new CreateUserCommand($usersRepository);

try {
    //"Заворачиваем" $argv в объект типа Arguments
    $command->handle(Arguments::fromArgv($argv));
}
    // Так как мы добавили исключение ArgumentsException
    // имеет смысл обрабатывать все исключения приложения,
    // а не только исключение CommandException
catch (CommandException $e) {
    //Выводим сообщения об ошибках
    echo "{$e->getMessage()}\n";
}

//Добавляем в репозиторий несколько пользователей
//$usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Ivanov')));
//$usersRepository->save(new User(UUID::random(), new Name('Sergey', 'Misharin')));
