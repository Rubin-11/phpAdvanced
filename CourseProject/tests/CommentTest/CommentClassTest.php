<?php

use CourseProject\LevelTwo\Blog\Comment\Comment;
use CourseProject\LevelTwo\Common\UUID;
use PHPUnit\Framework\TestCase;

class CommentClassTest extends TestCase
{
    public function testConstructor():void{
        $arg = new Comment(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            new UUID("123e4567-e89b-12d3-a456-426614174002"),
            "test_text"
        );
        $value = (string)$arg;
        $this->assertEquals("id=123e4567-e89b-12d3-a456-426614174000, authorId=123e4567-e89b-12d3-a456-426614174001, postId=123e4567-e89b-12d3-a456-426614174002, text=test_text",trim($value));
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
    private function getComment(): Comment
    {
        return new Comment(UUID::random(),UUID::random(),UUID::random(), "text" );
    }

    private function CommentsProviderForMethodSetAndGetId():iterable{
        return [ ["123e4567-e89b-12d3-a456-426614174111", "123e4567-e89b-12d3-a456-426614174111"],
            ["123e4567-e89b-12d3-a456-426614174222", "123e4567-e89b-12d3-a456-426614174222"],
            ["123e4567-e89b-12d3-a456-426614174333", "123e4567-e89b-12d3-a456-426614174333"]
        ];
    }

    /**
     * @dataProvider CommentsProviderForMethodSetAndGetId
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
    public function testCommentSetAndGetId($inputValue, $expectedValue){
        $post = $this->getComment();
        $post->setIdComment(new UUID($inputValue));

        $this->assertEquals($expectedValue, (string)$post->getIdComment());
    }

    /**
     * @dataProvider CommentsProviderForMethodSetAndGetId
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     */
    public function testCommentSetAndGetAuthorId($inputValue, $expectedValue){
        $post = $this->getComment();
        $post->setAuthorId(new UUID($inputValue));

        $this->assertEquals($expectedValue, (string)$post->getAuthorId());
    }

    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @dataProvider CommentsProviderForMethodSetAndGetId
     */
    public function testCommentSetAndGetAuthorArticleId($inputValue, $expectedValue){
        $post = $this->getComment();
        $post->setPostId(new UUID($inputValue));

        $this->assertEquals($expectedValue, (string)$post->getPostId());
    }

    private function CommentsProviderForMethodSetAndGetText():iterable{
        return [ ["text1", "text1"],
            ["text2", "text2"],
            ["text3", "text3"]
        ];
    }

    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @dataProvider CommentsProviderForMethodSetAndGetText
     */
    public function testArticleSetAndGetText($inputValue, $expectedValue){
        $post = $this->getComment();
        $post->setText($inputValue);

        $this->assertEquals($expectedValue, (string)$post->getText());
    }
}