<?php

namespace CourseProject\LevelTwo\Exceptions;

use Exception;

class ArticleNotFoundException extends Exception
{
    protected $message = 'Article not found';
}