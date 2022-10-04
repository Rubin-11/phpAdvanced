<?php

namespace CourseProject\LevelTwo\Repositories\UsersRepository;

use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\UUID;

interface UserRepositoryInterface
{
    public function save(User $user):void;
    public function get(UUID $idUser): User;
    public function getByUsername(string $username): User;
}