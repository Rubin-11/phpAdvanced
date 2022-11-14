<?php

namespace CourseProject\LevelTwo\UnitTests\Container;

use CourseProject\LevelTwo\Blog\Container\DIContainer;
use CourseProject\LevelTwo\Exceptions\NotFoundException;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepository;
use CourseProject\LevelTwo\Repositories\UsersRepository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DIContainerTest extends TestCase
{
    public function testItThrowsAnExceptionIfCannotResolveType(): void
    {
        //  Создаем объект контейнера
        $container = new DIcontainer();

        //  Описываем ожидаемое исключение
        $this->expectException(NotFoundException::class);

        $this->expectErrorMessage('Cannot resolve type: CourseProject\LevelTwo\UnitTests\Container\SomeClass');

        //  Пытаемся получить объект не существующего класса
        $container->get(SomeClass::class);
    }

    public function testItResolvesClassWithoutDependencies(): void
    {
        //  Создаем объект контейнера
        $container = new DIContainer();

        //  Пытаемся получить объект класса без зависимостей
        $object = $container->get(SomeClassWithoutDependencies::class);

        //  Проверяем, что объект, который вернул контейнер, имеет желаемый тип
        $this->assertInstanceOf(
            SomeClassWithoutDependencies::class,
            $object
        );
    }

    public function testItResolvesClassByContract(): void
    {
        // Создаём объект контейнера
        $container = new DIContainer();

        // Устанавливаем правило, по которому
        // всякий раз, когда контейнеру нужно
        // создать объект, реализующий контракт
        // UsersRepositoryInterface, он возвращал бы
        // объект класса InMemoryUsersRepository
        $container->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        // Пытаемся получить объект класса,
        // реализующего контракт UsersRepositoryInterface
        $object = $container->get(UserRepositoryInterface::class);

        // Проверяем, что контейнер вернул
        // объект класса InMemoryUsersRepository
        $this->assertInstanceOf(
            UserRepository::class,
            $object
        );
    }

    public function testItReturnsPredefinedObject(): void
    {
        // Создаём объект контейнера
        $container = new DIContainer();

        // Устанавливаем правило, по которому
        // всякий раз, когда контейнеру нужно
        // вернуть объект типа SomeClassWithParameter,
        // он возвращал бы предопределённый объект
        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        // Пытаемся получить объект типа SomeClassWithParameter
        $object = $container->get(SomeClassWithParameter::class);

        // Проверяем, что контейнер вернул
        // объект того же типа
        $this->assertInstanceOf(
            SomeClassWithParameter::class,
            $object
        );

        // Проверяем, что контейнер вернул
        // тот же самый объект
        $this->assertSame(42, $object->value());
    }

    public function testItResolvesClassWithDependencies(): void
    {
        // Создаём объект контейнера
        $container = new DIContainer();

        // Устанавливаем правило получения
        // объекта типа SomeClassWithParameter
        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        // Пытаемся получить объект типа ClassDependingOnAnother
        $object = $container->get(ClassDependingOnAnother::class);

        // Проверяем, что контейнер вернул
        // объект нужного нам типа
        $this->assertInstanceOf(
            ClassDependingOnAnother::class,
            $object
        );
    }
}