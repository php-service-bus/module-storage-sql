<?php

/**
 * SQL adapters support module.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Storage\Module\Tests;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use ServiceBus\Storage\Common\DatabaseAdapter;
use ServiceBus\Storage\Module\SqlStorageModule;
use ServiceBus\Storage\Sql\DoctrineDBAL\DoctrineDBALAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 */
final class SqlStorageModuleTest extends TestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     */
    public function create(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(['service_bus.logger' => new Definition(Logger::class)]);

        SqlStorageModule::inMemory()->boot($containerBuilder);

        $testDefinition = new Definition(TestDependency::class, [new Reference(DatabaseAdapter::class)]);
        $testDefinition->setPublic(true);

        $containerBuilder->addDefinitions([TestDependency::class => $testDefinition]);

        $containerBuilder->compile();

        /** @var TestDependency $test */
        $test = $containerBuilder->get(TestDependency::class);

        static::assertInstanceOf(DoctrineDBALAdapter::class, $test->adapter);
    }
}
