<?php

use CourseProject\LevelTwo\Exceptions\ArticleNotFoundException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Exceptions\CommentNotFoundException;

use CourseProject\LevelTwo\Repositories\ArticleRepository\ArticleRepository;
use CourseProject\LevelTwo\Repositories\CommentRepository\CommentRepository;
use CourseProject\LevelTwo\Repositories\UsersRepository\UsersRepository;

use CourseProject\LevelTwo\User;
use CourseProject\LevelTwo\Article;
use CourseProject\LevelTwo\Comment;

require_once __DIR__ . '/vendor/autoload.php';

$facer = Faker\Factory::create();

$usersRepository = new UsersRepository();
$articleRepository = new ArticleRepository();
$commentRepository = new CommentRepository();

$user = new User(
    1,
    $firstName = $facer->firstName,
    $lastName = $facer->lastName
);
try {
    $usersRepository->save($user);
    $user = $usersRepository->get(1);
    print $user . PHP_EOL;
}catch (UserNotFoundException $exception) {
    print $exception->getMessage() . PHP_EOL;
}

$article = new Article(
    2,
    $user->getId(),
    $heading = $facer->name,
    $text = $facer->text(200)
);
try {
    $articleRepository->save($article);
    $article = $articleRepository->get(2);
    print $article . PHP_EOL;
}catch (ArticleNotFoundException $exception) {
    print $exception->getMessage() . PHP_EOL;
}

$comment = new Comment(
    3,
    $user->getId(),
    $article->getIdAuthor(),
    $text = $facer->text(200)
);
try {
    $commentRepository->save($comment);
    $comment = $commentRepository->get(3);
    print $comment . PHP_EOL;
}catch (CommentNotFoundException $exception) {
    print $exception->getMessage() . PHP_EOL;
}