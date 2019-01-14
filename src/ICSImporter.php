<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar as CalendarModel;
use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\RecurrenceRule;

class ICSImporter
{
    public function importFromFile(string $csvFile)
    {
        return $this->importFromString(file_get_contents($csvFile));
    }

    public function importFromString(string $string)
    {
        $vcalendar = VObject\Reader::read($string);

        $calendar = new CalendarModel();

        if (!isset($vcalendar->VEVENT)) {
            return $calendar;
        }

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

            if (isset($vevent->CLASS)) {
                $event->setClassification($vevent->CLASS->getValue());
            }

            $calendar->addEvent($event);
        }

        return $calendar;
    }
}
