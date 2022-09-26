<?php

namespace CourseProject\LevelTwo\Repositories\UsersRepository;

use CourseProject\LevelTwo\User;

interface UserRepositoryInterface
{
    public function save($user):void;
    public function get(int $id): User;
}