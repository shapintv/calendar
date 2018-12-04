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
        $this->assertCount(3, $calendar->getEvents());
    }
}
