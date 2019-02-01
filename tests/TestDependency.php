<?php

/**
 * SQL adapters support module
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Storage\Module\Tests;

use ServiceBus\Storage\Common\DatabaseAdapter;

/**
 * @property-read DatabaseAdapter $adapter
 */
final class TestDependency
{
    /**
     * @var DatabaseAdapter
     */
    public $adapter;

    /**
     * @param DatabaseAdapter $adapter
     */
    public function __construct(DatabaseAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
