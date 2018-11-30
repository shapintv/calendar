<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

use Shapin\Calendar\Configuration\TimezoneConfiguration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.6.5
 */
class Timezone
{
    /**
     * Property Name: TZID
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
