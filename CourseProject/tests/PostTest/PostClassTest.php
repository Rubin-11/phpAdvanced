<?php

use CourseProject\LevelTwo\Blog\Post\Post;
use CourseProject\LevelTwo\Common\UUID;
use PHPUnit\Framework\TestCase;

class PostClassTest extends TestCase
{
    public function testConstructor(): void
    {
        $arg = new Post(
            new UUID("123e4567-e89b-12d3-a456-426614174000"),
            new UUID("123e4567-e89b-12d3-a456-426614174001"),
            "title",
            "text"
        );
        $value = (string)$arg;
        $this->assertEquals(
            "id=123e4567-e89b-12d3-a456-426614174000, authorId=123e4567-e89b-12d3-a456-426614174001, title=title, text=text",
            trim($value)
        );
    }

    public function getPost():Post
    {
        return new Post(UUID::random(),UUID::random(),"test", "text");
    }

    private function PostProviderForMethodSetAndGetId():iterable{
        return [ ["123e4567-e89b-12d3-a456-426614174111", "123e4567-e89b-12d3-a456-426614174111"],
            ["123e4567-e89b-12d3-a456-426614174222", "123e4567-e89b-12d3-a456-426614174222"],
            ["123e4567-e89b-12d3-a456-426614174333", "123e4567-e89b-12d3-a456-426614174333"]
        ];
    }


    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @dataProvider PostProviderForMethodSetAndGetId
     */
    public function testPostSetAndGetId($inputValue, $expectedValue){
        $post = $this->getPost();
        $post->setIdPost(new UUID($inputValue));
        $this->assertEquals($expectedValue, (string)$post->getIdPost());
    }

    private function PostProviderForMethodSetAndGetAuthorId():iterable{
        return [ ["123e4567-e89b-12d3-a456-426614174111", "123e4567-e89b-12d3-a456-426614174111"],
            ["123e4567-e89b-12d3-a456-426614174222", "123e4567-e89b-12d3-a456-426614174222"],
            ["123e4567-e89b-12d3-a456-426614174333", "123e4567-e89b-12d3-a456-426614174333"]
        ];
    }

    /**
     * @throws \CourseProject\LevelTwo\Exceptions\InvalidArgumentException
     * @dataProvider PostProviderForMethodSetAndGetAuthorId
     */
    public function testPostSetAndGetAuthorId($inputValue, $expectedValue){
        $post = $this->getPost();
        $post->setAuthorId(new UUID($inputValue));

        $this->assertEquals($expectedValue, (string)$post->getAuthorId());
    }

    private function PostProviderForMethodSetAndGetTitle():iterable{
        return [ ["title1", "title1"],
            ["title2", "title2"],
            ["title3", "title3"]
        ];
    }

    /**
     * @dataProvider PostProviderForMethodSetAndGetTitle
     */
    public function testPostSetAndGetTitle($inputValue, $expectedValue){
        $post = $this->getPost();
        $post->setTitle($inputValue);

        $this->assertEquals($expectedValue, (string)$post->getTitle());
    }

    private function PostProviderForMethodSetAndGetText():iterable{
        return [ ["text1", "text1"],
            ["text2", "text2"],
            ["text3", "text3"]
        ];
    }

    /**
     * @dataProvider PostProviderForMethodSetAndGetText
     */
    public function testPostSetAndGetText($inputValue, $expectedValue){
        $post = $this->getPost();
        $post->setText($inputValue);

        $this->assertEquals($expectedValue, (string)$post->getText());
    }
}