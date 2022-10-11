<?php

use CourseProject\LevelTwo\Common\UUID;
use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UuidExceptionTest extends TestCase
{
    public function testInvalidArgumentException(){
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Malformed UUID: 12");

        $id = new UUID("12");
    }
}