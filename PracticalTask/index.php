<?php

//require_once __DIR__ . '/vendor/autoload.php';

use src\Blog_Post\Class_Post;
use src\Person\Name;
use src\Person\Person;

spl_autoload_register(function (string $class) {
//    var_dump($class);
//    die();
    $pathArray = explode('\\', $class);
//    var_dump($pathArray);
//    die();
    $className = str_replace('_', DIRECTORY_SEPARATOR, array_pop($pathArray));
//    var_dump($className);
//    die();
    require_once sprintf('%s.php', implode(DIRECTORY_SEPARATOR, array_merge($pathArray, [$className])));
//    var_dump($class);
//    die();
});

$post = new Class_Post(
    new Person(
        new Name('Иван', 'Никитин'),
        new DateTimeImmutable()
    ),
    'Всем привет!'
);

print $post;
