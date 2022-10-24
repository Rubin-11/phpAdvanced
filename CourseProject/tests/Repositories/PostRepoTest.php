<?php

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\PostNotFoundException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Repositories\PostRepository\SqlitePostRepository;
use PHPUnit\Framework\TestCase;

class PostRepoTest extends TestCase
{
    public function testItSavesArticleToDatabase():void{
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method("prepare")->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with([
                ':id_post' => "123e4567-e89b-12d3-a456-426614174000",
                ':author_id' => "123e4567-e89b-12d3-a456-426614174001",
                ':title' =>"title",
                ':text' =>"text" ]
        )->willReturn(true);

        $sqlRepo = new SqlitePostRepository($connectionMock);
        // Свойства пользователя точно такие,как и в описании мока
        $sqlRepo->save(new Post(
                new UUID("123e4567-e89b-12d3-a456-426614174000"),
                new UUID("123e4567-e89b-12d3-a456-426614174001"),
                "title",
                "text")
        );
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function testExceptionWhenUserNotFound(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with(
            [ // Даём понятьь что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
                ':id_post' => '123e4567-e89b-12d3-a456-426614174000']
        );
        $statementMock->method('fetch')->willReturn(false);

        $sqlRepo=new SqlitePostRepository($connectionMock);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("Cannot find post: 123e4567-e89b-12d3-a456-426614174000");

        $sqlRepo->get(new UUID('123e4567-e89b-12d3-a456-426614174000'));
    }


    public function testGetArticleByTitle(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with(
            [ // Даём понятьь что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
                ':title' => 'title']
        );
        $statementMock->method('fetch')->willReturn([
            'id_post'=>'123e4567-e89b-12d3-a456-426614174000',
            'author_id'=>'123e4567-e89b-12d3-a456-426614174001',
            'title'=>'title',
            'text'=> 'text'
        ]);

        $sqlRepo=new SqlitePostRepository($connectionMock);

        $user = new Post(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            "title",
            "text");

        $value = $sqlRepo->getByTitle('title');

        $this->assertEquals($user, $value);
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function testGetArticleByAuthor(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with(
            [ // Даём понятьь что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
                'author_id' => '123e4567-e89b-12d3-a456-426614174001']
        );
        $statementMock->method('fetch')->willReturn([
            'id_post'=>'123e4567-e89b-12d3-a456-426614174000',
            'author_id'=>'123e4567-e89b-12d3-a456-426614174001',
            'title'=>'title',
            'text'=> 'text'
        ]);

        $sqlRepo=new SqlitePostRepository($connectionMock);

        $user = new Post(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            "title",
            "text");

        $value = $sqlRepo->getByAuthor(new UUID("123e4567-e89b-12d3-a456-426614174001"));

        $this->assertEquals($user, $value);
    }
}