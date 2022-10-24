<?php

namespace CourseProject\LevelTwo\UnitTests;

use CourseProject\LevelTwo\Exceptions\InvalidArgumentException;
use CourseProject\LevelTwo\Common\UUID;
use PHPUnit\Framework\TestCase;

class UuidExceptionTest extends TestCase
{
    public function testInvalidArgumentException(){
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Malformed UUID: 12");

        $id = new UUID("12");
    }
}