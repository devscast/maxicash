# Maxicash PHP

![Lint](https://github.com/devscast/maxicash/actions/workflows/lint.yaml/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/devscast/maxicash/version)](https://packagist.org/packages/devscast/maxicash)
[![Total Downloads](https://poser.pugx.org/devscast/maxicash/downloads)](https://packagist.org/packages/devscast/maxicash)
[![License](https://poser.pugx.org/devscast/maxicash/license)](https://packagist.org/packages/devscast/maxicash)


The MaxiCash Integration Platform enables Merchants to integrate with the MaxiCash platform in order to receive payments through their mobile apps or their websites. The API uses JSON to interact with .Net client or open source platforms like PHP. see more at [Maxicash Documentation](https://developer.maxicashapp.com/Default)

## Installation
You can use the PHP client by installing the Composer package and adding it to your application’s dependencies:

```bash
composer require devscast/maxicash
```
## Usage 
The MaxiCash Gateway enables the Merchant to Collect Payment into their MaxiCash account using multiple payment channels such as Credit Cards, MaxiCash, Paypal, Mobile Money and Mobile Banking.

### Authentication
* **Step 1**. Download the MaxiCash Mobile App and signup...
* **Step 2**. Contact us to upgrade your account to a Merchant Account info@maxicashapp.com
You will receive a Merchant Form to complete in order to provide your business details and preffered Cashout Wallet or Banking Details.
* **Step 3**. Once the paperwork is completed, you will be issued with Live and Sandbox Accounts (MerchantID and MerchantPassword)


```php
use Devscast\Maxicash\Client as Maxicash;
use Devscast\Maxicash\Credential;
use Devscast\Maxicash\PaymentEntry;
use Devscast\Maxicash\Environment;

$maxicash = new Maxicash(
    credential: new Credential('marchand_id', 'marchand_password'),
    environment: Environment::SANDBOX // use `Environment::LIVE` for live
);
```

### Create a Payment Entry
```php
$entry = new PaymentEntry(
    credential: $maxicash->credential,
    amount: intval(47.50 * 100), // amount in cents
    reference: "this text will be shown on maxicash payment page",
    acceptUrl: "your_website_accept_url",
    declineUrl: "your_website_decline_url",
);
```
> **Note**: we hightly recommand your `accept` and `decline` urls to be unique for each transaction, thus users will not be able to reuse them to validate other transactions, on your side save the transaction with a unique generated token (a.k.a transaction reference) and use it as parameter to your accept and decline urls, don't use it for the `PaymentEntry->reference`; once the user is redirected to your accept url, validate the token and grant access to the paid resource (with your own business logic). 


### Redirect to Maxicash Gateway
Redirect your user to the maxicash gateway to continue the payment process

```php
$url = $maxicash->queryStringURLPayment($entry);
```
> **Note** : we highly recommand to do a `server side` redirection, this url can be modified and leak your maxicash credentials when displayed to your user in any manner (eg: a link, button or form) ! you can use the `header("Location: $url")` fonction in vanilla PHP or return a `RedirectResponse($url)` in your controller when using Symfony or Laravel frameworks`

### Donate Button for NGOs
Once you signup as an NGO Merchant

```php
$donationUrl = $maxicash->donationUrl()
```

## Features supported
- [x] QueryString URL Payment
- [x] Donate Button for NGOs
- [ ] Form Post Payment
- [ ] Pay Entry Web
