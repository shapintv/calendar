<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\RecurrenceRule;

class EventsFlattener
{
    public function flatten(Event $event): array
    {
        if (!$event->isRecurring()) {
            return [
                $event->getStartAt()->getTimestamp() => $event,
            ];
        }

        $parts = $event->getRecurrenceRule()->getParts();

        if (!isset($parts['FREQ'])) {
            throw new \BadMethodCallException("RecurrenceRule doesn't contains a FREQ. Not implemented yet.");
        }

        if (isset($parts['BYDAY']) && is_array($parts['BYDAY'])) {
            $events = [];
            foreach ($parts['BYDAY'] as $day) {
                $startAt = $this->changeDateToGivenDay($event->getStartAt(), $day);
                $endAt = $this->changeDateToGivenDay($event->getEndAt(), $day);

                $dailyEventRecurrenceRuleParts = array_merge($parts, [
                    'BYDAY' => $day,
                ]);

                $dailyEvent = $this->createEventFromRecurring($event, $startAt, $endAt);
                $dailyEvent->setRecurrenceRule(RecurrenceRule::createFromArray($dailyEventRecurrenceRuleParts));

                $events += $this->getAllRecurringEvents($dailyEvent);
            }

            return $events;
        }

        if (!isset($parts['BYDAY']) || !is_array($parts['BYDAY'])) {
            return $this->getAllRecurringEvents($event);
        }

        throw new \BadMethodCallException('Looks like this case is not implemented yet...');
    }

    private function getAllRecurringEvents(Event $event): array
    {
        $freq = $event->getRecurrenceRule()->getParts()['FREQ'];

        $startAt = $event->getStartAt();
        $duration = $event->getEndAt()->diff($startAt);
        $modifier = $this->getModifier($freq);

        $events = [$event->getStartAt()->getTimestamp() => $event];
        $until = $this->getLastEvent($event);
        $nextEventStartAt = $startAt->modify($modifier);
        while ($nextEventStartAt < $until) {
            $newEvent = $this->createEventFromRecurring($event, $nextEventStartAt, $nextEventStartAt->add($duration));

            $events[$newEvent->getStartAt()->getTimestamp()] = $newEvent;
            $nextEventStartAt = $nextEventStartAt->modify($modifier);
        }

        return $events;
    }

    private function getModifier(string $freq, int $times = 1): string
    {
        if ('WEEKLY' === $freq) {
            return "+$times week";
        }
        if ('MONTHLY' === $freq) {
            return "+$times month";
        }

        throw new \BadMethodCallException("Unknown freq $freq");
    }

    private function getLastEvent(Event $event): \DateTimeImmutable
    {
        $parts = $event->getRecurrenceRule()->getParts();
        $firstEventStartAt = $event->getStartAt();

        if (isset($parts['UNTIL'])) {
            return new \DateTimeImmutable($parts['UNTIL']);
        }

        if (isset($parts['COUNT'])) {
            return $firstEventStartAt->modify($this->getModifier($parts['FREQ'], (int) $parts['COUNT']));
        }

        throw new \BadMethodCallException('Not implemented recurring rule.');
    }

    private function changeDateToGivenDay(\DateTimeInterface $date, string $day)
    {
        $days = ['MO' => 1, 'TU' => 2, 'WE' => 3, 'TH' => 4, 'FR' => 5, 'SA' => 6, 'SU' => 0];

        $expectedDayNumber = $days[$day];
        $dateDayNumber = (int) $date->format('w');

        $diff = $expectedDayNumber - $dateDayNumber;

        if (0 === $diff) {
            return $date;
        }

        if ($diff < 0) {
            $diff += 7;
        }

        return $date->modify("+$diff days");
    }

    private function createEventFromRecurring(Event $event, \DateTimeInterface $from, \DateTimeInterface $to): Event
    {
        $newEvent = new Event($from, $to);
        if (null !== $summary = $event->getSummary()) {
            $newEvent->setSummary($summary);
        }
        if (null !== $description = $event->getDescription()) {
            $newEvent->setDescription($description);
        }

        return $newEvent;
    }
}
