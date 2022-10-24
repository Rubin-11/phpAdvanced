<?php

namespace CourseProject\LevelTwo\Common;

use CourseProject\LevelTwo\Exceptions\ArgumentException;

class Arguments
{
    private array $arguments = [];

    public function __construct(iterable $arguments)
    {
        foreach ($arguments as $argument => $value) {
            // Приводим к строкам
            $stringValue = trim((string)$value);
            // Пропускаем пустые значения
            if (empty($stringValue)) {
                continue;
            }
            // Также приводим к строкам ключ
            $this->arguments[(string)$argument] = $stringValue;
        }
    }

    public static function fromArgv(array $argv):Arguments{
        $arguments = [];
        foreach ($argv as $value){
            $parts = explode('=', $value);
            if(count($parts)!==2){
                continue;
            }
            $arguments[$parts[0]] = $parts[1];
        }
        return new self($arguments);
    }

    /**
     * @throws ArgumentException
     */
    public function getArg(string $arg):string{
        if(!array_key_exists($arg, $this->arguments)){
            throw new ArgumentException("No such argument: $arg");
        }
        return $this->arguments[$arg];
    }
}