<?php

namespace CourseProject\LevelTwo\Http\Action\LikeAction;

use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\LikeNotFoundException;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\LikesRepository\LikesRepositoryInterface;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;

class FindLikesByArticle implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
        private PostRepositoryInterface $postRepository
    ) {}

    public function handle(Request $request): Response
    {
        $message = [];
        try{
            $id = $request->query('id');
        }catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        try{
            $post = $this->postRepository->get(new UUID($id));
        }catch (PostNotFoundException|InvalidArgumentException $e){
            return new ErrorResponse($e->getMessage());
        }

        try{
            $postLikes = $this->likesRepository->getAllByArticle(new UUID($id));
        }catch (LikeNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        } catch (InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $i=0;
        foreach ($postLikes as $like){
            $message[$i] = [
                "id"=>(string)$like->getLike(),
                "article"=>(string)$like->getArticle(),
                "user"=> (string)$like->getUser()
            ];
            $i++;
        }
        return new SuccessResponse($message);
    }
}