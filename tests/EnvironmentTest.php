<?php

namespace Devscast\Maxicash\Tests;

use PHPUnit\Framework\TestCase;
use Devscast\Maxicash\Environment;

/**
 * Class EnvironmentTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EnvironmentTest extends TestCase
{
    public function testGetBaseUrl(): void
    {
        $this->assertEquals(
            'https://api.maxicashapp.com',
            Environment::LIVE->getBaseUrl()
        );
        $this->assertEquals(
            'https://api-testbed.maxicashapp.com',
            Environment::SANDBOX->getBaseUrl()
        );
    }
}
