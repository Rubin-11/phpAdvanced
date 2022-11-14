<?php

namespace CourseProject\LevelTwo\Http\Action\LikeAction;

use CourseProject\LevelTwo\Blog\Like\Like;
use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\HttpException;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\LikeNotFoundException;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Http\Action\ActionInterface;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\Response;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\LikesRepository\LikesRepositoryInterface;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;

class CreateLike implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postsRepository,
        private ?UserRepositoryInterface $usersRepository,
        private LikesRepositoryInterface $likesRepository
    ) {}

    public function handle(Request $request): Response
    {
        $idLike = UUID::random();

        try{
            $postId = new UUID($request->jsonBodyField('postId'));
            $userId = new UUID($request->jsonBodyField('userId'));
        }catch (HttpException|InvalidArgumentException $e){
            return new ErrorResponse($e->getMessage());
        }

        try{
            $post = $this->postsRepository->get($postId);
        }catch (PostNotFoundException $exception){
            return new ErrorResponse("No post created");
        }

        try{
            $user = $this->usersRepository->get($userId);
        }catch (UserNotFoundException $exception){
            return new ErrorResponse("No user created");
        }

        if(!$this->LikeExist($post, $user)){
            return new ErrorResponse("Post already like by you");
        }

        $this->likesRepository->save(new Like(
            $idLike,
            $postId,
            $userId
        ));

        return new SuccessResponse([
            'message'=> "Like successfully saved $idLike."
        ]);
    }

    private function LikeExist(Post $post, User $user):bool{
        try {
            $postLikes = $this->likesRepository->getAllByArticle($post->getIdPost());
        }catch (LikeNotFoundException $exception){
            return true;
        }

        foreach ($postLikes as $like){
            if($like->getUser() == $user->getIdUser()){
                return false;
            }
        }
        return true;
    }
}