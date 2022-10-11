<?php

use CourseProject\LevelTwo\Common\Arguments;

use PHPUnit\Framework\TestCase;
use CourseProject\LevelTwo\Exceptions\ArgumentException;


class ArgumentsClassTest extends TestCase
{
    private function argumentProvider(): array
    {
        return [
            ['some_string', 'some_string'], // Тестовый набор

            [' some_string', 'some_string'], // Тестовый набор №2
            [' some_string ', 'some_string'],
            [123, '123'],
            [12.3, '12.3'],
        ];
    }

    /**
     * @dataProvider argumentProvider
     * @throws ArgumentException
     */
    public function testItReturnsArgumentsValueByName($inputValue, $expectedValue){
        $arguments = new Arguments(["some_key"=>$inputValue]);

        $value = $arguments->getArg("some_key");

        $this->assertEquals($expectedValue,$value);
    }

    public function testArgumentException(){
        $arguments = new Arguments(["some_key"=>""]);
        $this->expectException(ArgumentException::class);
        $this->expectExceptionMessage("No such argument: some_key");

        $arguments->getArg("some_key");
    }

    private function argvProvider(){
        return [
            [['title=Geekbrains1'], ["title", "Geekbrains1"]], // Тестовый набор
            [['title=Geekbrains2'], ["title", "Geekbrains2"]], // Тестовый набор №2
            [['title=Geekbrains3'], ["title", "Geekbrains3"]],
        ];
    }

    /**
     * @dataProvider argvProvider
     * @throws ArgumentException
     */
    public function testArgumentFromArgv($inputValue, $expectedValue){
        $argument = Arguments::fromArgv($inputValue);

        $value = $argument->getArg($expectedValue[0]);

        $this->assertEquals($expectedValue[1], $value);
    }
}