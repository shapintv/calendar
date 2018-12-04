<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

class Calendar
{
    private $events = [];

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
