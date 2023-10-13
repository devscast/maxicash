<?php

declare(strict_types=1);

namespace Devscast\Maxicash\Data;

/**
 * Class Currency.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum Currency: string
{
    case DOLLAR = 'maxiDollar';
    case RAND = 'maxiRand';
}
