<?php

namespace CourseProject\LevelTwo\Http\Action;

use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}