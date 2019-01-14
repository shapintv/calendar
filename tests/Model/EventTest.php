<?php

declare(strict_types=1);

namespace Shapin\Calendar\Tests;

use PHPUnit\Framework\TestCase;
use Shapin\Calendar\Model\Event;

class EventTest extends TestCase
{
    public function testIsBetween()
    {
        $event = new Event(new \DateTimeImmutable('2019-06-22 14:00'), new \DateTimeImmutable('2019-06-22 15:00'));
        $this->assertTrue($event->isBetween(new \DateTimeImmutable('2019-06-22'), new \DateTimeImmutable('2019-06-23')));
        $this->assertTrue($event->isBetween(new \DateTimeImmutable('2019-06-22'), new \DateTimeImmutable('2019-06-23'), false));

        $this->assertFalse($event->isBetween(new \DateTimeImmutable('2019-06-22 13:00'), new \DateTimeImmutable('2019-06-22 14:30')));
        $this->assertTrue($event->isBetween(new \DateTimeImmutable('2019-06-22 13:00'), new \DateTimeImmutable('2019-06-22 14:30'), false));

        $this->assertFalse($event->isBetween(new \DateTimeImmutable('2019-06-22 13:00'), new \DateTimeImmutable('2019-06-22 13:30')));
        $this->assertFalse($event->isBetween(new \DateTimeImmutable('2019-06-22 13:00'), new \DateTimeImmutable('2019-06-22 13:30')));
    }
}
