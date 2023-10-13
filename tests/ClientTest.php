<?php

declare(strict_types=1);

namespace Devscast\Maxicash\Tests;

use Devscast\Maxicash\Client;
use PHPUnit\Framework\TestCase;
use Devscast\Maxicash\Credential;
use Devscast\Maxicash\PaymentEntry;

/**
 * Class ClientTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ClientTest extends TestCase
{
    public function testDonationUrl(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/donationentry?data={MerchantID:"merchant_id",Language:"en"}',
            $client->donationUrl()
        );

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/donationentry?data={MerchantID:"merchant_id",Language:"fr"}',
            $client->donationUrl('fr')
        );
    }

    public function testFormPostPayment(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/PayEntryPost',
            $client->formPostPayment()
        );
    }

    public function testQueryStringURLPayment(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $paymentEntry = new PaymentEntry(
            credential: $credential,
            amount: 100,
            reference: 'reference',
            acceptUrl: 'https://example.com/accept',
            declineUrl: 'https://example.com/cancel',
        );

        $exceptedData = '{PayType:"MaxiCash",Amount:"100",Currency:"maxiDollar",Telephone:"",MerchantID:"merchant_id",MerchantPassword:"merchant_key",Language:"en",Reference:"reference",Accepturl:"https://example.com/accept",Cancelurl:"",Declineurl:"https://example.com/cancel",NotifyURL:""}';

        $this->assertEquals(
            "https://api-testbed.maxicashapp.com/PayEntry?data=$exceptedData",
            $client->queryStringURLPayment($paymentEntry)
        );
    }

    public function testPayEntryWeb(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/Integration/PayEntryWeb',
            $client->payEntryWeb()
        );
    }

    public function testPayEntryWebLog(): void
    {
        $credential = new Credential('merchant_id', 'merchant_key');
        $client = new Client($credential);

        $this->assertEquals(
            'https://api-testbed.maxicashapp.com/payentryweb?logid=id',
            $client->payEntryWebLog('id')
        );
    }
}
