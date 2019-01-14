<?php

declare(strict_types=1);

namespace Shapin\Calendar\Model;

class Event
{
    private $startAt;
    private $endAt;
    private $summary;
    private $description;
    private $recurrenceRule;
    private $recurrenceId;
    private $classification;

    public function __construct(\DateTimeImmutable $startAt, \DateTimeImmutable $endAt)
    {
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function isRecurring(): bool
    {
        return null !== $this->recurrenceRule;
    }

    public function isARecurrence(): bool
    {
        return null !== $this->recurrenceId;
    }

    public function isBetween(\DateTimeImmutable $from, \DateTimeImmutable $to, bool $strict = true): bool
    {
        if ($strict) {
            return $this->startAt > $from && $this->endAt < $to;
        }

        if ($this->endAt < $from) {
            return false;
        }

        if ($this->startAt > $to) {
            return false;
        }

        return true;
    }

    public function getLastEventStartAt(): \DateTimeImmutable
    {
        if (!$this->isRecurring()) {
            throw new \BadMethodCallException('Not a recurring event');
        }

        return $this->getRecurrenceRule()->getLastEvent($this->getStartAt());
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRecurrenceRule(): ?RecurrenceRule
    {
        return $this->recurrenceRule;
    }

    public function setRecurrenceRule(RecurrenceRule $recurrenceRule): self
    {
        $this->recurrenceRule = $recurrenceRule;

        return $this;
    }

    public function getRecurrenceId(): ?\DateTimeImmutable
    {
        return $this->recurrenceId;
    }

    public function setRecurrenceId(\DateTimeImmutable $recurrenceId): self
    {
        $this->recurrenceId = $recurrenceId;

        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function isPrivate()
    {
        return 'PRIVATE' === $this->classification;
    }

    /**
     * Public by default
     * @see https://tools.ietf.org/html/rfc5545#section-3.8.1.3
     */
    public function isPublic()
    {
        return 'PUBLIC' === $this->classification || null === $this->classification;
    }
}
