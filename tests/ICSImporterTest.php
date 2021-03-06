<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\ICSImporter;
use Shapin\Calendar\Model\Calendar;

class ICSImporterTest extends TestCase
{
    public function testImportEmpty()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/empty.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertFalse($calendar->hasEvents());
        $this->assertCount(0, $calendar->getEvents());
        $this->assertCount(0, $calendar->getFlattenedEvents());
    }

    public function testImportBasic()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/basic.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertTrue($calendar->hasEvents());
        $this->assertCount(3, $calendar->getEvents());
        $this->assertCount(18, $calendar->getFlattenedEvents());
    }

    public function testImportBasicEventFromGCalendar()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/basic_event_from_gcalendar.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertTrue($calendar->hasEvents());
        $this->assertCount(1, $calendar->getEvents());

        $events = $calendar->getEvents();
        $event = reset($events);
        $this->assertEquals('Let\'s play babyfoot', $event->getSummary());
        $this->assertTrue($event->isPrivate());
        $this->assertFalse($event->isPublic());
    }

    public function testImportModifiedRecurringEvents()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/modified_recurring_events.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertTrue($calendar->hasEvents());
        $this->assertCount(6, $calendar->getEvents());
        $this->assertCount(18, $calendar->getFlattenedEvents());
    }

    public function testImportMonthlyRecurringEvents()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/updated_monthly_recurring_events.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertTrue($calendar->hasEvents());
        $this->assertCount(2, $calendar->getEvents());
        $this->assertCount(3, $calendar->getFlattenedEvents());
    }

    public function testImportTwoTimesAWeekEvents()
    {
        $importer = new ICSImporter();

        $calendar = $importer->importFromFile(__DIR__.'/fixtures/recurring_event_2_times_per_week.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertTrue($calendar->hasEvents());
        $this->assertCount(1, $calendar->getEvents());
        $this->assertCount(44, $calendar->getFlattenedEvents());
    }
}
