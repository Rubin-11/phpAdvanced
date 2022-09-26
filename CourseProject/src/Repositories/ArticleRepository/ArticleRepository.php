<?php

namespace CourseProject\LevelTwo\Repositories\ArticleRepository;

use CourseProject\LevelTwo\Article;
use CourseProject\LevelTwo\Exceptions\ArticleNotFoundException;

class ArticleRepository implements ArticleRepositoryInterface
{
    private array $articles = [];

    public function save($article):void
    {
        $this->articles[] = $article;
    }

    /**
     * @throws ArticleNotFoundException
     */
    public function get(int $id):Article
    {
        foreach ($this->articles as $article) {
            if($article->getId() === $id) {
                return $article;
            }
        }
        throw new ArticleNotFoundException();
    }
}