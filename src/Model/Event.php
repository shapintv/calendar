<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
 */
class Event
{
    /**
     * Property Name: UID.
     */
    private $uid;

    /**
     * Property Name: DTSTAMP.
     */
    private $createdAt;

    /**
     * Property Name: DTSTART.
     */
    private $startAt;

    /**
     * Property Name: DTEND.
     */
    private $endAt;

    /**
     * Property Name: SUMMARY.
     */
    private $summary;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public function getUid(): string
    {
        return $this->uid;
    }
}
