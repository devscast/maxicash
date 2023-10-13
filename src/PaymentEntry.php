<?php

declare(strict_types=1);

namespace Devscast\Maxicash;

use Devscast\Maxicash\Data\Currency;
use Devscast\Maxicash\Data\Language;
use Devscast\Maxicash\Data\PayType;
use Webmozart\Assert\Assert;

/**
 * Class PaymentEntry.
 *
 * @see https://developer.maxicashapp.com/
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class PaymentEntry
{
    /**
     * @param Credential  $credential The Merchant ID authenticates the merchant on the platform This parameter is compulsory.
     *                                The Merchant Password works in conjunction with the MerchantID to authenticate the merchant on the platform This parameter is compulsory.
     * @param int         $amount     Amount expected for the transaction. This amount will be reloaded in your MaxiCash Account. This parameter is compulsory.
     *                                Please note that the amounts are expected in Cents. Meaning that if you would like to process a payment of 1 USD,
     *                                you must send an amount of 10
     * @param string      $reference  This is a transaction reference used by the merchant. This parameter is compulsory.
     * @param string      $acceptUrl  This is the merchant web page that the payer will be redirected to when his payment succeeds. This parameter is compulsory.
     *                                The MaxiCash Gateway will add a few query string parameters described below.
     * @param string|null $cancelUrl  This is the merchant web page that the payer will be redirected to in case he chooses to cancel the payment This parameter is optional.
     *                                The MaxiCash Gateway will add a few query string parameters described below. If this parameter is not specified, MaxiCash will defaults to the declineurl
     * @param string      $declineUrl This is the merchant web page that the payer will be redirected to in case the payment fails.
     *                                MaxiCash also defaults to this parameter in case the cancelurl is not specified.
     *                                This parameter is compulsory. The MaxiCash Gateway will add a few query string parameters described below.
     * @param string|null $notifyUrl  This parameter is used to notify the merchant website of the status of the transaction before the payer is redirected to the accepturl, declineurl or failureurl
     *                                This parameter is optional but recommended. The MaxiCash Gateway will add a few query string parameters described below
     * @param string|null $phone      Telephone number of the payer. This parameter is optional. Generally used for Mobile Money Payment methods
     * @param string|null $email      Email address of the payer. This parameter is optional. Generally used for Credit Card Payments
     * @param PayType     $payType    Always to be set to MaxiCash unless specified otherwise. This parameter is compulsory.
     * @param Currency    $currency   Currency of the transaction. This parameter is compulsory. Generally takes in 4 values: USD, ZAR, maxiRand or maxiDollar.
     * @param Language    $language   Allows you to specify a language on the gateway.This parameter is optional.
     *                                Currently only English (en) and French (fr) are supported. When not specified, the system defaults to English.
     */
    public function __construct(
        public Credential $credential,
        public int $amount,
        public string $reference,
        public string $acceptUrl,
        public string $declineUrl,
        public ?string $cancelUrl = null,
        public ?string $notifyUrl = null,
        public ?string $phone = null,
        public ?string $email = null,
        public PayType $payType = PayType::MAXICASH,
        public Currency $currency = Currency::DOLLAR,
        public Language $language = Language::EN
    ) {
        Assert::greaterThanEq($this->amount, 0, 'Amount must be greater than 0');
        Assert::notEmpty($this->reference, 'Reference must not be empty');
        Assert::notEmpty($this->acceptUrl, 'Accept url must be a valid url');
        Assert::notEmpty($this->declineUrl, 'Decline url must be a valid url');
    }

    /**
     * used when gateway is set to HTTP_POST.
     */
    public function post(): array
    {
        return [
            'PayType' => $this->payType->value,
            'Amount' => $this->amount,
            'Currency' => $this->currency->value,
            'MerchantPassword' => $this->credential->merchantKey,
            'MerchantID' => $this->credential->merchantId,
            'Language' => $this->language->value,
            'Telephone' => $this->phone,
            'Email' => $this->email,
            'Reference' => $this->reference,
            'accepturl' => $this->acceptUrl,
            'declineurl' => $this->declineUrl,
            'cancelurl' => $this->cancelUrl ?? $this->declineUrl,
            'notifyurl' => $this->notifyUrl,
        ];
    }

    /**
     * used when gateway is set to HTTP_GET.
     * notice that is not json encoded.
     */
    public function get(): string
    {
        $data = <<< DATA
            {
                PayType:"{$this->payType->value}",
                Amount:"{$this->amount}",
                Currency:"{$this->currency->value}",
                Telephone:"{$this->phone}",
                MerchantID:"{$this->credential->merchantId}",
                MerchantPassword:"{$this->credential->merchantKey}",
                Language:"{$this->language->value}",
                Reference:"{$this->reference}",
                Accepturl:"{$this->acceptUrl}",
                Cancelurl:"{$this->cancelUrl}",
                Declineurl:"{$this->declineUrl}",
                NotifyURL:"{$this->notifyUrl}"
            }
        DATA;

        return trim((string) preg_replace('/\s+/', '', $data));
    }

    /**
     * used when gateway is set to JSON.
     *
     * @throws \JsonException
     */
    public function json(): string
    {
        $data = [
            'PayType' => $this->payType->value,
            'Amount' => $this->amount,
            'Currency' => $this->currency->value,
            'MerchantPassword' => $this->credential->merchantKey,
            'MerchantID' => $this->credential->merchantId,
            'Language' => $this->language->value,
            'Telephone' => $this->phone,
            'Email' => $this->email,
            'Reference' => $this->reference,
            'SuccessURL' => $this->acceptUrl,
            'FailureURL' => $this->declineUrl,
            'CancelURL' => $this->cancelUrl ?? $this->declineUrl,
            'NotifyURL' => $this->notifyUrl,
        ];

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
