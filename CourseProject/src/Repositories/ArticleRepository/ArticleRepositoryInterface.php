<?php

namespace CourseProject\LevelTwo\Repositories\ArticleRepository;

use CourseProject\LevelTwo\Article;

interface ArticleRepositoryInterface
{
    public function save($article):void;
    public function get(int $id):Article;
}