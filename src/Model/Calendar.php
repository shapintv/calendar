<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

use Shapin\Calendar\EventsFlattener;

class Calendar
{
    private $events = [];

    public function getFlattenedEvents(): array
    {
        $flattener = new EventsFlattener();

        $events = [];
        $eventsInARecurrence = [];
        $recurringEvents = [];
        foreach ($this->getEvents() as $event) {
            if ($event->isARecurrence()) {
                $eventsInARecurrence[] = $event;

                continue;
            }

            if ($event->isRecurring()) {
                $recurringEvents[] = $event;

                continue;
            }

            $events[$event->getStartAt()->getTimestamp()] = $event;
        }

        // Deal with recurring events
        foreach ($recurringEvents as $event) {
            $events += $flattener->flatten($event);
        }

        // Replace recurring events with updated ones
        foreach ($eventsInARecurrence as $event) {
            $events[$event->getRecurrenceId()->getTimestamp()] = $event;
        }

        ksort($events);

        return $events;
    }

    public function hasEventBetween(\DateTimeImmutable $from, \DateTimeImmutable $to, bool $strict = true): bool
    {
        return 0 > count($this->getEventsBetween($form, $to, $strict));
    }

    public function getEventsBetween(\DateTimeImmutable $from, \DateTimeImmutable $to, bool $strict = true)
    {
        $events = [];
        foreach ($this->getFlattenedEvents() as $event) {
            if ($event->isBetween($from, $to, $strict)) {
                $events[] = $event;
            }
        }

        return $events;
    }

    public function getNextEvent(): ?Event
    {
        $nextEvents = $this->getUpcomingEvents();

        if (0 === count($nextEvents)) {
            return null;
        }

        return reset($nextEvents);
    }

    public function getUpcomingEvents(): array
    {
        return $this->getEventsAfter(new \DateTimeImmutable());
    }

    public function getEventsAfter(\DateTimeInterface $date): array
    {
        if (!$this->hasEvents()) {
            return [];
        }

        $events = [];
        foreach ($this->getFlattenedEvents() as $event) {
            if ($event->getStartAt() > $date) {
                $events[] = $event;
            }
        }

        return $events;
    }

    public function hasEvents(): bool
    {
        return 0 < count($this->events);
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
