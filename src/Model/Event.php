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
}
