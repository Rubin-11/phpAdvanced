<?php

use CourseProject\LevelTwo\Blog\Comment\Comment;
use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\CommentNotFoundException;
use CourseProject\LevelTwo\Exceptions\UserNotFoundException;
use CourseProject\LevelTwo\Repositories\CommentRepository\SqliteCommentRepository;
use PHPUnit\Framework\TestCase;

class CommentRepoTest extends TestCase
{
    public function testItSavesArticleToDatabase():void{
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method("prepare")->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with([
                ':id_comment' => "123e4567-e89b-12d3-a456-426614174000" ,
                ':post_id' => "123e4567-e89b-12d3-a456-426614174001" ,
                ':author_id' => "123e4567-e89b-12d3-a456-426614174002" ,
                ':text' => "text"
            ])->willReturn(true);

        $sqlRepo = new SqliteCommentRepository($connectionMock);
        // Свойства пользователя точно такие,как и в описании мока
        $sqlRepo->save(new Comment(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174002"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            "text"
        ));
    }


    public function testExceptionWhenUserNotFound(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->expects($this->once())->method('execute')->with(
            [ // Даём понятьь что метод execute вызовется лишь 1 раз с единственным аргументом - массивом
                ':id_comment' => '123e4567-e89b-12d3-a456-426614174000']
        );
        $statementMock->method('fetch')->willReturn(false);

        $sqlRepo=new SqliteCommentRepository($connectionMock);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage("Cannot find comment: 123e4567-e89b-12d3-a456-426614174000");

        $sqlRepo->get(new UUID('123e4567-e89b-12d3-a456-426614174000'));
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function testGetCommentByAuthor(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->method('fetch')->willReturn([
            'id_comment'=>'123e4567-e89b-12d3-a456-426614174000',
            'post_id'=>'123e4567-e89b-12d3-a456-426614174001',
            'author_id'=>"123e4567-e89b-12d3-a456-426614174002",
            'text'=> 'text'
        ]);

        $sqlRepo=new SqliteCommentRepository($connectionMock);

        $user = new Comment(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            new UUID("123e4567-e89b-12d3-a456-426614174002"),
            "text");

        $value = $sqlRepo->getByAuthor(new UUID("123e4567-e89b-12d3-a456-426614174002"));

        $this->assertEquals($user, $value);
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function testGetCommentByArticle(){
        $connectionMock = $this->createStub(PDO::class);
        $statementMock = $this->createStub(PDOStatement::class);

        $connectionMock->method('prepare')->willReturn($statementMock);

        $statementMock->method('fetch')->willReturn([
            'id_comment'=>'123e4567-e89b-12d3-a456-426614174000',
            'post_id'=>'123e4567-e89b-12d3-a456-426614174001',
            'author_id'=>"123e4567-e89b-12d3-a456-426614174002",
            'text'=> 'text'
        ]);

        $sqlRepo=new SqliteCommentRepository($connectionMock);

        $user = new Comment(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            new UUID("123e4567-e89b-12d3-a456-426614174002"),
            "text");

        $value = $sqlRepo->getByPost(new UUID("123e4567-e89b-12d3-a456-426614174001"));

        $this->assertEquals($user, $value);
    }
}