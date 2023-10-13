<?php

declare(strict_types=1);

namespace Devscast\Maxicash;

use Webmozart\Assert\Assert;

/**
 * Class Credential.
 *
 * @see info@maxicashapp.com
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class Credential
{
    public string $merchantId;

    public string $merchantKey;

    /**
     * @param string $merchantId  the Merchant ID authenticates the merchant on the platform This parameter is compulsory
     * @param string $merchantKey the Merchant Password works in conjunction with the MerchantID to authenticate
     *                            the merchant on the platform This parameter is compulsory
     */
    public function __construct(
        #[\SensitiveParameter] string $merchantId,
        #[\SensitiveParameter] string $merchantKey,
    ) {
        Assert::notEmpty($merchantId, 'Merchant ID cannot be empty');
        Assert::notEmpty($merchantKey, 'Merchant Key or password cannot be empty');

        $this->merchantId = $merchantId;
        $this->merchantKey = $merchantKey;
    }
}
