<?php

declare(strict_types=1);

namespace Devscast\Maxicash;

/**
 * Class Client.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class Client
{
    public function __construct(
        public Credential $credential,
        private Environment $environment = Environment::SANDBOX,
    ) {
    }

    public function donationUrl(string $language = 'en'): string
    {
        return vsprintf(
            format: '%s/donationentry?data={MerchantID:"%s",Language:"%s"}',
            values: [$this->environment->getBaseUrl(), $this->credential->merchantId, $language]
        );
    }

    public function formPostPayment(): string
    {
        return sprintf('%s/PayEntryPost', $this->environment->getBaseUrl());
    }

    public function queryStringURLPayment(PaymentEntry $data): string
    {
        return sprintf('%s/PayEntry?data=%s', $this->environment->getBaseUrl(), $data->get());
    }

    public function payEntryWeb(): string
    {
        return sprintf('%s/Integration/PayEntryWeb', $this->environment->getBaseUrl());
    }

    public function payEntryWebLog(string $id): string
    {
        return sprintf('%s/payentryweb?logid=%s', $this->environment->getBaseUrl(), $id);
    }
}
