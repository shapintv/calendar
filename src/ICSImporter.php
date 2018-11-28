<?php

declare(strict_types=1);

namespace Shapin\Calendar;

use Sabre\VObject;
use Shapin\Calendar\Model\Calendar as CalendarModel;

class ICSImporter
{
    public function import(string $csvFile)
    {
        $vcalendar = VObject\Reader::read(fopen($csvFile, 'r'));

        return CalendarModel::createFromArray([
            'product_identifier' => $vcalendar->PRODID->getValue(),
        ]);
    }
}
