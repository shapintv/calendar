<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\ICSImporter;
use Shapin\Calendar\Model\Calendar;

class ICSImporterTest extends TestCase
{
    public function testImportBasic()
    {
        $importer = new ICSImporter();

        $calendar = $importer->import(__DIR__.'/fixtures/basic.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertCount(3, $calendar->getEvents());
        $this->assertCount(18, $calendar->getFlattenedEvents());
    }

    public function testImportModifiedRecurringEvents()
    {
        $importer = new ICSImporter();

        $calendar = $importer->import(__DIR__.'/fixtures/modified_recurring_events.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertCount(6, $calendar->getEvents());
        $this->assertCount(18, $calendar->getFlattenedEvents());
    }

    public function testImportMonthlyRecurringEvents()
    {
        $importer = new ICSImporter();

        $calendar = $importer->import(__DIR__.'/fixtures/updated_monthly_recurring_events.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertCount(2, $calendar->getEvents());
        $this->assertCount(3, $calendar->getFlattenedEvents());
    }
}
