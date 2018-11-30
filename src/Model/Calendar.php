<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

use Shapin\Calendar\Configuration\CalendarConfiguration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @see https://tools.ietf.org/html/rfc5545
 */
class Calendar
{
    /**
     * Property Name: PRODID
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.3
     */
    private $productIdentifier;

    /**
     * Property Name: VERSION
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.4
     */
    private $version;

    /**
     * Property Name: CALSCALE
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.1
     */
    private $scale = 'GREGORIAN';

    /**
     * Property Name: METHOD
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.7.2
     */
    private $method;

    /**
     * Property Name: VTIMEZONE
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.5
     */
    private $timezones = [];

    /**
     * Property Name: VEVENT
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
     */
    private $events = [];

    public function __construct(string $productIdentifier, string $version)
    {
        $this->productIdentifier = $productIdentifier;
        $this->version = $version;
    }

    public function getProductIdentifier(): string
    {
        return $this->productIdentifier;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getScale(): string
    {
        return $this->scale;
    }

    public function setScale(string $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function addTimezone(Timezone $timezone): self
    {
        $this->timezones[] = $timezone;

        return $this;
    }

    public function getTimezones(): array
    {
        return $this->timezones;
    }

    public function addEvent(Event $event): self
    {
        $this->events[] = $event;

        return $this;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
