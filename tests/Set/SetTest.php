<?php

declare(strict_types=1);

namespace Micoli\Multitude\Tests\Set;

use Micoli\Multitude\Exception\EmptySetException;
use Micoli\Multitude\Set\AbstractSet;
use Micoli\Multitude\Set\ImmutableSet;
use Micoli\Multitude\Set\MutableSet;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class SetTest extends TestCase
{
    public static function provideMapClass(): iterable
    {
        yield MutableSet::class => [MutableSet::class];
        yield ImmutableSet::class => [ImmutableSet::class];
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_instantiate_a_set(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray([1, 3, 4 => 'a']);
        self::assertSame([1, 3, 'a'], $set->toArray());
        self::assertSame([0, 1, 2], iterator_to_array($set->keys()));
        self::assertCount(3, $set);
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_be_counted(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray(['a', 'b', 3, 0, null]);
        self::assertCount(5, $set);
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_be_iterated(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray(['a', 'b', 3, 0, null]);
        $result = '';
        foreach ($set as $v) {
            $result = sprintf('%s,%s', $result, $v);
        }
        self::assertSame(',a,b,3,0,', $result);

        $result = '';
        foreach ($set->values() as $v) {
            $result = sprintf('%s,%s', $result, $v);
        }
        self::assertSame(',a,b,3,0,', $result);
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_iterate_keys(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray(['a', 'b', 3, 0, null]);
        $keyList = '';
        foreach ($set->keys() as $k) {
            $keyList .= $k . ',';
        }
        self::assertSame('0,1,2,3,4,', $keyList);
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_get_first_element(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray(['a', 'b', 3, 0, null]);
        self::assertSame('a', $set->first());

        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray([]);
        self::assertSame(null, $set->first(false));

        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray([]);
        self::expectException(EmptySetException::class);
        $set->first();
    }

    /**
     * @test
     *
     * @dataProvider provideMapClass
     *
     * @param class-string<AbstractSet> $className
     */
    public function it_should_get_last_element(string $className): void
    {
        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray(['a', 'b', 3, 0, null, 'last']);
        self::assertSame('last', $set->last());

        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray([]);
        self::assertSame(null, $set->last(false));

        /** @var ImmutableSet<mixed> $set */
        $set = $className::fromArray([]);
        self::expectException(EmptySetException::class);
        $set->last();
    }
}
