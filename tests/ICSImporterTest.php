<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\ICSImporter;
use Shapin\Calendar\Model\Calendar;

class ICSImporterTest extends TestCase
{
    public function testImport()
    {
        $importer = new ICSImporter();

        $calendar = $importer->import(__DIR__.'/fixtures/basic.ics');
        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertSame('-//Google Inc//Google Calendar 70.9054//EN', $calendar->getProductIdentifier());
        $this->assertSame('2.0', $calendar->getVersion());
        $this->assertSame('GREGORIAN', $calendar->getScale());
        $this->assertSame('PUBLISH', $calendar->getMethod());

        $this->assertCount(1, $calendar->getTimezones());
        $this->assertCount(3, $calendar->getEvents());
    }
}
