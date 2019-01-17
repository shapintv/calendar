<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

class RecurrenceRule
{
    private $parts;

    private function __construct()
    {
    }

    public static function createFromArray(array $parts): self
    {
        $rule = new self();
        $rule->parts = $parts;

        return $rule;
    }

    public function getModifier(int $times = 1): string
    {
        if (!isset($this->parts['FREQ'])) {
            throw new \BadMethodCallException("RecurrenceRule doesn't contains a FREQ. Not implemented yet.");
        }

        $freq = $this->parts['FREQ'];

        if ('WEEKLY' === $freq) {
            return "+$times week";
        }
        if ('MONTHLY' === $freq) {
            return "+$times month";
        }

        throw new \BadMethodCallException("Unknown freq $freq");
    }

    public function getLastEvent(\DateTimeImmutable $firstEventStartAt): \DateTimeImmutable
    {
        if (isset($this->parts['UNTIL'])) {
            return new \DateTimeImmutable($this->parts['UNTIL']);
        }

        if (isset($this->parts['COUNT'])) {
            return $firstEventStartAt->modify($this->getModifier((int) $this->parts['COUNT']));
        }

        throw new \BadMethodCallException('Not implemented recurring rule.');
    }

    public function getParts(): array
    {
        return $this->parts;
    }
}
