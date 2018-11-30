<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar as CalendarModel;
use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\Timezone;

class ICSImporter
{
    public function import(string $csvFile)
    {
        $vcalendar = VObject\Reader::read(fopen($csvFile, 'r'));

        $calendar = new CalendarModel($vcalendar->PRODID->getValue(), $vcalendar->VERSION->getValue());
        $calendar->setScale(null !== $vcalendar->CALSCALE ? $vcalendar->CALSCALE->getValue() : null);
        $calendar->setMethod(null !== $vcalendar->METHOD ? $vcalendar->METHOD->getValue() : null);

        foreach ($vcalendar->VTIMEZONE as $timezone) {
            $calendar->addTimezone(new Timezone($timezone->TZID->getValue()));
        }

        foreach ($vcalendar->VEVENT as $event) {
            $calendar->addEvent(new Event($event->UID->getValue()));
        }

        return $calendar;
    }
}
