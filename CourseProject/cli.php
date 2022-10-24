<?php

require_once __DIR__ . '/vendor/autoload.php';
$const = new PDO('sqlite:' . __DIR__ . '/blog_course_project.sqlite');
//print($const);
//die();

use CourseProject\LevelTwo\Common\Arguments;
use CourseProject\LevelTwo\Blog\User\CreateUserCommand;
use CourseProject\LevelTwo\Blog\Post\CreatePostCommand;
use CourseProject\LevelTwo\Blog\Comment\CreateCommentCommand;
use CourseProject\LevelTwo\Repositories\CommentRepository\SqliteCommentRepository;
use CourseProject\LevelTwo\Repositories\PostRepository\SqlitePostRepository;
use CourseProject\LevelTwo\Repositories\UsersRepository\SqliteUserRepository;
use Rubin\LevelTwo\Blog\Exceptions\AppException;

try {
    //Создаём репозиторий для сохранения в базу данных, но с помощью интерфейса можно легко
    // переключить работу, на с охранение данных локально в программе
    $userRepository = new SqliteUserRepository($const);
    $postRepository = new SqlitePostRepository($const);
    $commentRepository = new SqliteCommentRepository($const);
    if(count($argv)>0) {
        //получаем ассоциативный массив из командной строки с аргументами
        $arguments = Arguments::fromArgv($argv);

        //создаём класс для создания пользователей.
//        $createUser = new CreateUserCommand($userRepository);
//        $createUser->handle($arguments);


//        $user = $userRepository->getByUsername($arguments->getArg('user_name'));
//        $createPost = new CreatePostCommand($postRepository);
//        $createPost->handle($arguments, $user->getIdUser());
//        $createPost->handle($arguments);

//        $post2 = $postRepository->getByAuthor($user->getId());
//        $post = $postRepository->getByTitle('IgorLox');
        $createComment = new CreateCommentCommand($commentRepository);
//        $createComment->handle($arguments,$user->getId(), $article->getId());
        $createComment->handle($arguments);

    }
}catch (AppException $e) {
        echo $e->getMessage();
}

