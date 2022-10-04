<?php

namespace Rubin\LevelTwo\Blog;

class Name
{
    public function __construct(
        private readonly string $first,
        private readonly string $last
    )
    {
    }

    /**
     * @return string
     */
    public function first(): string
    {
        return $this->first;
    }

    /**
     * @return string
     */
    public function last(): string
    {
        return $this->last;
    }

    public function __toString()
    {
        return $this->first . ' ' . $this->last;
    }
}