<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar as CalendarModel;
use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\RecurrenceRule;

class ICSImporter
{
    public function import(string $csvFile)
    {
        $vcalendar = VObject\Reader::read(fopen($csvFile, 'rb'));

        $calendar = new CalendarModel();

        foreach ($vcalendar->VEVENT as $vevent) {
            $event = new Event($vevent->DTSTART->getDateTime(), $vevent->DTEND->getDateTime());
            $event
                ->setSummary($vevent->SUMMARY->getValue())
                ->setDescription($vevent->DESCRIPTION->getValue())
            ;

            if (isset($vevent->RRULE)) {
                $event->setRecurrenceRule(RecurrenceRule::createFromArray($vevent->RRULE->getParts()));
            } elseif (isset($vevent->{'RECURRENCE-ID'})) {
                $event->setRecurrenceId($vevent->{'RECURRENCE-ID'}->getDateTime());
            }

            $calendar->addEvent($event);
        }

        return $calendar;
    }
}
