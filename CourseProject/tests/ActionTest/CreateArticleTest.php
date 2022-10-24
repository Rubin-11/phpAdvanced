<?php

namespace CourseProject\LevelTwo\UnitTests;

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Blog\User\User;
use CourseProject\LevelTwo\Common\Name;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Http\ErrorResponse;
use CourseProject\LevelTwo\Http\Request;
use CourseProject\LevelTwo\Http\SuccessResponse;
use CourseProject\LevelTwo\Repositories\PostRepository\PostRepositoryInterface;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;
use CourseProject\LevelTwo\Http\Action\PostAction\CreatePost;
use JsonException;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;


class CreateArticleTest extends TestCase
{
    private function usersRepository(array $users): UserRepositoryInterface
    {
        // В конструктор анонимного класса передаём массив пользователей
        return new class($users) implements UserRepositoryInterface {
            public function __construct(
                private readonly array $users
            ) {}

            public function save(User $user): void
            {
            }

            public function get(UUID $idUser): User
            {
                foreach ($this->users as $user) {
                    if ($user instanceof User && (string)$idUser === (string)$user->getIdUser()) {
                        return $user;
                    }
                }
                throw new UserNotFoundException("Not found");
            }

            public function getByUsername(string $username): User
            {
                foreach ($this->users as $user) {
                    if ($user instanceof User && $username === $user->getUsername()) {
                        return $user;
                    }
                }
                throw new UserNotFoundException("Not found");
            }
        };
    }

    private function PostRepository(array $post): PostRepositoryInterface
    {
        // В конструктор анонимного класса передаём массив пользователей
        return new class($post) implements PostRepositoryInterface {
            private bool $flag = false;

            public function __construct(
                private readonly array $post,
            )
            {
            }


            public function save(Post $post): void
            {
                $this->flag = true;
            }

            public function get(UUID $idPost): Post
            {
                throw new PostNotFoundException("Not found");
            }

            public function getByTitle(string $title): Post
            {
            }

            public function getByAuthor(UUID $id): Post
            {
            }

            public function getFlag(): bool
            {
                return $this->flag;
            }

            public function deliteById(UUID $id)
            {

            }
        };
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws Exception|JsonException
     */
    public function testItReturnsErrorResponseIfGetBadUuid()
    {
        $request = new Request([], [], '{"authorId": "12"}');
        $usersRepository = $this->usersRepository([]);
        $postRepository = $this->postRepository([]);

        $action = new CreatePost($postRepository, $usersRepository);

        $response = $action->handle($request);
        //$this->assertInstanceOf(InvalidArgumentException::class, $response);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Malformed UUID: 12"}');

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws InvalidArgumentException|JsonException
     */
    public function testItReturnsErrorResponseIfUserNotFound()
    {
        $request = new Request([], [], '{
            "authorId": "8ddd0fbc-a047-453d-b1f3-d587933270c4",
            "title": "test_for_delete",
            "text": "Dont delete me pls"}'
        );
        $usersRepository = $this->usersRepository([new User(
            UUID::random(),
            new Name('Ivan', 'Nikitin'),
            'ivan',)
        ]);

        $postRepository = $this->postRepository([]);

        $action = new CreatePost($postRepository, $usersRepository);

        $response = $action->handle($request);
        //$this->assertInstanceOf(\CourseProject\LevelTwok\Exceptions\InvalidArgumentException::class, $response);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function testItReturnsErrorResponseIfNotAllParamsEmpty()
    {
        $request = new Request([], [], '{
            "authorId": "8ddd0fbc-a047-453d-b1f3-d587933270c4",
            "title": "test_for_delete",
            "text": ""}'
        );
        $usersRepository = $this->usersRepository(
            [new User(
                UUID::random(),
                new Name('Ivan', 'Nikitin'),
                'ivan',
            ),]
        );
        $articleRepository = $this->postRepository([]);

        $action = new CreatePost($articleRepository, $usersRepository);

        $response = $action->handle($request);
        //$this->assertInstanceOf(\CourseProject\LevelTwok\Exceptions\InvalidArgumentException::class, $response);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Empty field: text"}');

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function testItReturnsErrorResponseIfNotAllParams()
    {
        $request = new Request([], [], '{
            "authorId": "8ddd0fbc-a047-453d-b1f3-d587933270c4",
            "title": "test_for_delete"}'
        );
        $usersRepository = $this->usersRepository(
            [new User(
            UUID::random(),
            new Name('Ivan', 'Nikitin'),
            'ivan',
            ),]
        );
        $postRepository = $this->postRepository([]);

        $action = new CreatePost($postRepository, $usersRepository);

        $response = $action->handle($request);
        //$this->assertInstanceOf(\CourseProject\LevelTwok\Exceptions\InvalidArgumentException::class, $response);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such field: text"}');

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws JsonException
     */
    public function testItReturnsSuccessfulResponse()
    {
        $request = new Request([], [], '{
            "authorId": "8ddd0fbc-a047-453d-b1f3-d587933270c4",
            "title": "test_for_delete",
            "text": "Dont delete me pls"}'
        );
        $usersRepository = $this->usersRepository(
            [new User(
                new UUID("8ddd0fbc-a047-453d-b1f3-d587933270c4"),
                new Name('Ivan', 'Nikitin'),
                'ivan',
            ),]
        );
        $postRepository = $this->postRepository([]);

        $action = new CreatePost($postRepository, $usersRepository);

        $response = $action->handle($request);
        //$this->assertInstanceOf(\CourseProject\LevelTwok\Exceptions\InvalidArgumentException::class, $response);
        $this->assertInstanceOf(SuccessResponse::class, $response);
        //$this->expectOutputString('{"success":false,"reason":"No such field: text"}');
        $this->assertTrue($postRepository->getFlag());
        $response->send();
    }
}