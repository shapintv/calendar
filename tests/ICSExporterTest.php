<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\ICSExporter;
use Shapin\Calendar\ICSImporter;
use Shapin\Calendar\Model\Calendar;

class ICSExporterTest extends TestCase
{
    /**
     * @dataProvider eventProviders
     */
    public function testExportEvent(string $fileName): void
    {
        $importer = new ICSImporter();
        $calendar = $importer->importFromFile($fileName);
        $events = $calendar->getEvents();
        $originalEvent = reset($events);

        $exporter = new ICSExporter();
        $newEventIcs = $exporter->exportEvent($originalEvent);

        $newEvents = $importer->importFromString($newEventIcs)->getEvents();
        $newEvent = reset($newEvents);

        $this->assertEquals($originalEvent->getStartAt(), $newEvent->getStartAt());
        $this->assertEquals($originalEvent->getEndAt(), $newEvent->getEndAt());
        $this->assertSame($originalEvent->getSummary(), $newEvent->getSummary());
        $this->assertSame($originalEvent->isPrivate(), $newEvent->isPrivate());
        $this->assertSame($originalEvent->isPublic(), $newEvent->isPublic());
        $this->assertSame($originalEvent->isRecurring(), $newEvent->isRecurring());
        if ($newEvent->isRecurring()) {
            $this->assertSame($originalEvent->getRecurrenceRule()->getParts(), $newEvent->getRecurrenceRule()->getParts());
        }
    }

    public function eventProviders()
    {
        return [
            [__DIR__.'/fixtures/basic_event_from_gcalendar.ics'],
            [__DIR__.'/fixtures/basic_recurring_event_from_gcalendar.ics'],
        ];
    }
}
