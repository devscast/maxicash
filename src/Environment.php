<?php

declare(strict_types=1);

namespace Devscast\Maxicash;

/**
 * Class Environment.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum Environment: string
{
    case LIVE = 'prod';
    case SANDBOX = 'dev';

    public function getBaseUrl(): string
    {
        return match ($this) {
            self::LIVE => 'https://api.maxicashapp.com',
            self::SANDBOX => 'https://api-testbed.maxicashapp.com',
        };
    }
}
