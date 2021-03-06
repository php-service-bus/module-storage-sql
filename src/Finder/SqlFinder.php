<?php

/**
 * SQL adapters support module.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Storage\Module\Finder;

use Amp\Promise;

/**
 *
 */
interface SqlFinder
{
    /**
     * Returns an array if successful and null if no record
     *
     * @param string|int $id
     *
     * @throws \ServiceBus\Storage\Common\Exceptions\InvalidConfigurationOptions
     * @throws \ServiceBus\Storage\Common\Exceptions\ConnectionFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\StorageInteractingFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\ResultSetIterationFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\OneResultExpected
     */
    public function findOneById($id): Promise;

    /**
     * Returns an array if successful and null if no record
     *
     * @param \Latitude\QueryBuilder\CriteriaInterface[] $criteria
     *
     * @throws \ServiceBus\Storage\Common\Exceptions\InvalidConfigurationOptions
     * @throws \ServiceBus\Storage\Common\Exceptions\ConnectionFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\StorageInteractingFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\ResultSetIterationFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\OneResultExpected
     */
    public function findOneBy(array $criteria): Promise;

    /**
     * Search for a collection by specified conditions
     *
     * @psalm-param array<string, string> $orderBy
     *
     * @param \Latitude\QueryBuilder\CriteriaInterface[] $criteria
     *
     * @throws \ServiceBus\Storage\Common\Exceptions\InvalidConfigurationOptions
     * @throws \ServiceBus\Storage\Common\Exceptions\ConnectionFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\StorageInteractingFailed
     * @throws \ServiceBus\Storage\Common\Exceptions\ResultSetIterationFailed
     */
    public function find(array $criteria, ?int $limit = null, array $orderBy = []): Promise;
}
