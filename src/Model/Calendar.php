<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

class Calendar
{
    private $events = [];

    public function getFlattenedEvents(): array
    {
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
            }

            $events[$event->getStartAt()->getTimestamp()] = $event;
        }

        // Deal with recurring events
        foreach ($recurringEvents as $event) {
            $startAt = $event->getStartAt();
            $duration = $event->getEndAt()->diff($startAt);
            $modifier = $event->getRecurrenceRule()->getModifier();

            $until = $event->getLastEventStartAt();
            $nextEventStartAt = $startAt->modify($modifier);
            while ($nextEventStartAt < $until) {
                $newEvent = new Event(
                    $nextEventStartAt,
                    $nextEventStartAt->add($duration)
                );
                $newEvent->setSummary($event->getSummary());
                $newEvent->setDescription($event->getDescription());

                $events[$newEvent->getStartAt()->getTimestamp()] = $newEvent;
                $nextEventStartAt = $nextEventStartAt->modify($modifier);
            }
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
        if (!$this->hasEvents()) {
            return null;
        }

        $now = new \DateTimeImmutable();

        // Flattened events are ordered by date. As soon as we found an event
        // starting after $now, we can return it directly.
        foreach ($this->getFlattenedEvents() as $event) {
            if ($event->getStartAt() > $now) {
                return $event;
            }
        }

        return null;
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
