<?php

namespace Rubin\LevelTwo\Blog\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';
}