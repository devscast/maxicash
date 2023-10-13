<?php

declare(strict_types=1);

namespace Devscast\Maxicash\Tests;

use PHPUnit\Framework\TestCase;
use Devscast\Maxicash\Credential;

/**
 * Class CredentialTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CredentialTest extends TestCase
{
    public function testConstructor(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');

        $this->assertEquals('merchant_id', $credential->merchantId);
        $this->assertEquals('merchant_key', $credential->merchantKey);
    }

    public function testConstructorEmptyMerchantId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Merchant ID cannot be empty');

        new Credential('', 'merchant_key');
    }

    public function testConstructorEmptyMerchantKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Merchant Key or password cannot be empty');

        new Credential('merchant_id', '');
    }
}
