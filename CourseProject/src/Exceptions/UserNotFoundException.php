<?php

namespace CourseProject\LevelTwo\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
}