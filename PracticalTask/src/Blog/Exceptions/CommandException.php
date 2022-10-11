<?php

namespace Rubin\LevelTwo\Blog\Exceptions;

use Exception;

class CommandException extends Exception
{
    protected $message = ' not found';
}