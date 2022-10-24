<?php

namespace CourseProject\LevelTwo\Http;

use JsonException;

abstract class Response
{
    //  Маркировка успешного ответа
    protected const  SUCCESS = true;

    //  Метод для отправки ответа

    /**
     * @throws JsonException
     */
    public function send(): void
    {
        //  Данные ответа:
        //  маркировка успешности и полезные данные
        $data = ['success' => static::SUCCESS] + $this->payload();

        //  Отправляем заголовок, говорящий, что в теле ответа будет JSON
        header('Content-Type: application/json');

        //  Кодируем данные в JSON и отправляем из в теле ответа
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    //  Декларация абстрактного медода,
    //  возвращающего полезные данные ответа
    abstract protected function payload(): array;
}