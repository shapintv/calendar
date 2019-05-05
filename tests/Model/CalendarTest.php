<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\Model\Calendar;

class CalendarTest extends TestCase
{
    public function testGetNextEventWithEmptyCalendar()
    {
        $calendar = new Calendar();
        $this->assertNull($calendar->getNextEvent());
    }
}
