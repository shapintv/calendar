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
    private $calendarScale;

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
    private $timezones;

    /**
     * Property Name: VEVENT
     *
     * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
     */
    private $events;

    private function __construct()
    {
    }

    public static function createFromArray(array $data): self
    {
        $processor = new Processor();
        $data = $processor->processConfiguration(new CalendarConfiguration(), [$data]);

        $calendar = new self();
        $calendar->productIdentifier = $data['product_identifier'];

        return $calendar;
    }

    public function getProductIdentifier()
    {
        return $this->productIdentifier;
    }
}
