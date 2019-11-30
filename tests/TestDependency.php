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

use ServiceBus\Storage\Common\DatabaseAdapter;

final class TestDependency
{
    public DatabaseAdapter $adapter;

    /**
     * @param DatabaseAdapter $adapter
     */
    public function __construct(DatabaseAdapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
