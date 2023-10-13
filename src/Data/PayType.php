<?php

declare(strict_types=1);

namespace Devscast\Maxicash\Data;

/**
 * Class PayType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum PayType: string
{
    case MAXICASH = 'MaxiCash';
    case BANK_TRANSFER = 'BankTransfer';
    case VISA = 'VISA';
    case MOBILE_MONEY = 'MobileMoney';
}
