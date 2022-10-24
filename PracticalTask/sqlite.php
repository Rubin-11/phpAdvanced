<?php

//Создаем обьект подключения к SQLite
$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

//Вставляем строку в таблицу пользователей
$connection->exec("INSERT INTO user (first_name, last_name) VALUES ('Ivan', 'Nikitin')");