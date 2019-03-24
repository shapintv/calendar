<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\EventsFlattener;
use Shapin\Calendar\Model\Calendar;
use Shapin\Calendar\Model\Event;
use Shapin\Calendar\Model\RecurrenceRule;

class EventsFlattenerTest extends TestCase
{
    public function testNonRecurringEvent()
    {
        $event = new Event(new \DateTimeImmutable('@1546855200'), new \DateTimeImmutable('@1546857000'));
        $event->setSummary('A test');

        $flattener = new EventsFlattener();
        $events = $flattener->flatten($event);

        $this->assertCount(1, $events);
        $this->assertSame($event, reset($events));
    }

    public function testMonthlyRecurringEvent()
    {
        $event = new Event(new \DateTimeImmutable('@1546855200'), new \DateTimeImmutable('@1546857000'));
        $event->setSummary('A test');
        $event->setRecurrenceRule(RecurrenceRule::createFromArray(['FREQ' => 'MONTHLY', 'COUNT' => 3, 'BYMONTHDAY' => 7]));

        $flattener = new EventsFlattener();
        $events = $flattener->flatten($event);

        $this->assertCount(3, $events);
    }

    public function testWeeklyRecurringEvent()
    {
        $event = new Event(new \DateTimeImmutable('@1544347800'), new \DateTimeImmutable('@1544350500'));
        $event->setDescription('A description');
        $event->setRecurrenceRule(RecurrenceRule::createFromArray(['FREQ' => 'WEEKLY', 'COUNT' => 6, 'BYDAY' => 'SU']));

        $flattener = new EventsFlattener();
        $events = $flattener->flatten($event);

        $this->assertCount(6, $events);
    }

    public function testBiWeeklyRecurringEvent()
    {
        $event = new Event(new \DateTimeImmutable('@1544347800'), new \DateTimeImmutable('@1544350500'));
        $event->setDescription('A description');
        $event->setRecurrenceRule(RecurrenceRule::createFromArray(['FREQ' => 'WEEKLY', 'COUNT' => 6, 'BYDAY' => ['MO', 'SU']]));

        $flattener = new EventsFlattener();
        $events = $flattener->flatten($event);

        $this->assertCount(12, $events);
    }
}
