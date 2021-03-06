<?php

declare(strict_types=1);

namespace Model\Payment\DomainEvents;

final class MailCredentialsWasRemoved
{
    /** @var int */
    private $credentialsId;

    public function __construct(int $credentialsId)
    {
        $this->credentialsId = $credentialsId;
    }

    public function getCredentialsId() : int
    {
        return $this->credentialsId;
    }
}
