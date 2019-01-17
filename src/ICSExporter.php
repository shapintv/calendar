<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar;
use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\RecurrenceRule;

class ICSExporter
{
    public function exportEvent(Event $event): string
    {
        $data = [
            'SUMMARY' => $event->getSummary(),
            'DESCRIPTION' => $event->getDescription(),
            'DTSTART' => $event->getStartAt(),
            'DTEND'   => $event->getEndAt(),
        ];
        if (null !== $event->getClassification()) {
            $data['CLASS'] = $event->getClassification();
        }

        if ($event->isRecurring()) {
            $data['RRULE'] = $event->getRecurrenceRule()->getParts();
        }

        $vcalendar = new VObject\Component\VCalendar([
            'VEVENT' => $data,
        ]);

        return $vcalendar->serialize();
    }
}
