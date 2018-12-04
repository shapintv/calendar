<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar as CalendarModel;
use Shapin\Calendar\Model\Event;

class ICSImporter
{
    public function import(string $csvFile)
    {
        $vcalendar = VObject\Reader::read(fopen($csvFile, 'rb'));

        $calendar = new CalendarModel();

        foreach ($vcalendar->VEVENT as $vevent) {
            $event = new Event($vevent->UID->getValue());
            $event
                ->setUid($vevent->UID->getValue())
                ->setSummary($vevent->SUMMARY->getValue())
                ->setDescription($vevent->DESCRIPTION->getValue())
                ->setStartAt($vevent->DTSTART->getDateTime())
                ->setEndAt($vevent->DTEND->getDateTime())
            ;

            $calendar->addEvent($event);
        }

        return $calendar;
    }
}
