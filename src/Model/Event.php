<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

/**
 * @see https://tools.ietf.org/html/rfc5545#section-3.6.1
 */
class Event
{
    /**
     * Property Name: UID
     */
    private $uniqId;

    /**
     * Property Name: DTSTAMP
     */
    private $createdAt;

    /**
     * Property Name: DTSTART
     */
    private $startAt;

    /**
     * Property Name: DTEND
     */
    private $endAt;

    /**
     * Property Name: SUMMARY
     */
    private $summary;

    public static function createFromArray(array $data): self
    {
        $event = new self();
        $event->uniqId = $data['uid'];

        return $event;
    }
}
