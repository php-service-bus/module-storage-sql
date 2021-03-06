<?php

/**
 * SQL adapters support module.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Storage\Module\Tests\Finder;

use Amp\Loop;
use PHPUnit\Framework\TestCase;
use ServiceBus\Cache\InMemory\InMemoryStorage;
use ServiceBus\Storage\Common\DatabaseAdapter;
use ServiceBus\Storage\Module\Finder\CachedSqlFinder;
use function Amp\Promise\wait;
use function ServiceBus\Common\uuid;
use function ServiceBus\Storage\Sql\DoctrineDBAL\inMemoryAdapter;

/**
 *
 */
final class CachedSqlFinderTest extends TestCase
{
    /**
     * @var DatabaseAdapter
     */
    private static $adapter;

    /**
     * {@inheritdoc}
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public static function setUpBeforeClass(): void
    {
        self::$adapter = inMemoryAdapter();

        wait(self::$adapter->execute('CREATE TABLE qwerty (id uuid PRIMARY KEY, title varchar NOT NULL)'));

        parent::setUpBeforeClass();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public static function tearDownAfterClass(): void
    {
        self::$adapter = null;

        /** @noinspection PhpInternalEntityUsedInspection */
        InMemoryStorage::instance()->clear();

        parent::tearDownAfterClass();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Throwable
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        wait(self::$adapter->execute('DELETE FROM qwerty'));

        /** @noinspection PhpInternalEntityUsedInspection */
        InMemoryStorage::instance()->clear();
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function selectOne(): void
    {
        Loop::run(
            static function (): \Generator
            {
                yield self::$adapter->execute(
                    'INSERT INTO qwerty(id, title) VALUES(?,?), (?,?)',
                    [
                        '28a3e51c-4944-44a7-bb79-b00fe38d9f0c', 'test1', '98c0ddc1-283b-4787-80ff-d706397922d9', 'test2',
                    ]
                );

                $finder = new CachedSqlFinder('qwerty', self::$adapter);

                /** @var array $entry */
                $entry = yield $finder->findOneById('28a3e51c-4944-44a7-bb79-b00fe38d9f0c');

                static::assertArrayHasKey('id', $entry);
                static::assertArrayHasKey('title', $entry);

                static::assertSame('28a3e51c-4944-44a7-bb79-b00fe38d9f0c', $entry['id']);

                /** Закешированное */

                /** @noinspection PhpInternalEntityUsedInspection */
                static::assertTrue(
                    InMemoryStorage::instance()->has('6e1488a47d01310e8697f3e980935b2d4d2c8df3')
                );

                /** @var array $entry */
                $entry = yield $finder->findOneById('28a3e51c-4944-44a7-bb79-b00fe38d9f0c');

                static::assertArrayHasKey('id', $entry);
                static::assertArrayHasKey('title', $entry);

                static::assertSame('28a3e51c-4944-44a7-bb79-b00fe38d9f0c', $entry['id']);
            }
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function selectAll(): void
    {
        Loop::run(
            static function (): \Generator
            {
                yield self::$adapter->execute(
                    'INSERT INTO qwerty(id, title) VALUES(?,?), (?,?)',
                    [uuid(), 'test1', uuid(), 'test2']
                );

                $finder = new CachedSqlFinder('qwerty', self::$adapter);

                /** @var array $rows */
                $rows = yield $finder->find([], 100, ['id' => 'DESC']);

                static::assertCount(2, $rows);

                /** Закешированное */

                /** @noinspection PhpInternalEntityUsedInspection */
                static::assertTrue(
                    InMemoryStorage::instance()->has('5c2a559f629ec7eb8cc42876c6fec726b3ab82f2')
                );

                /** @var array $rows */
                $rows = yield $finder->find([], 100, ['id' => 'DESC']);

                static::assertCount(2, $rows);
            }
        );
    }
}
