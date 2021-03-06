<?php

declare(strict_types=1);

namespace Model\DTO\Event;

use Model\Cashbook\Cashbook\CashbookId;

final class ExportedCashbook
{
    /** @var CashbookId */
    private $cashbookId;

    /** @var string */
    private $displayName;

    public function __construct(CashbookId $cashbookId, string $displayName)
    {
        $this->cashbookId  = $cashbookId;
        $this->displayName = $displayName;
    }

    public function getCashbookId() : CashbookId
    {
        return $this->cashbookId;
    }

    public function getDisplayName() : string
    {
        return $this->displayName;
    }
}
