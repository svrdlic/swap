<?php

/**
 * This file is part of Swap.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swap\Tests\Adapter;

use Swap\Adapter\Guzzle4Adapter;
use GuzzleHttp\Client;

class Guzzle4IntegrationTest extends AbstractIntegrationTestCase
{
    protected function setUp()
    {
        $this->adapter = new Guzzle4Adapter(new Client());
    }
}
