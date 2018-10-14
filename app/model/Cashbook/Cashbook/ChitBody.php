<?php

declare(strict_types=1);

namespace Model\Cashbook\Cashbook;

use Cake\Chronos\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class ChitBody
{
    /**
     * @var ChitNumber|NULL
     * @ORM\Column(type="chit_number", nullable=true, name="num")
     */
    private $number;

    /**
     * @var Date
     * @ORM\Column(type="chronos_date")
     */
    private $date;

    /**
     * @var Recipient|NULL
     * @ORM\Column(type="recipient", nullable=true)
     */
    private $recipient;

    /**
     * @var Amount
     * @ORM\Embedded(class=Amount::class, columnPrefix=false)
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $purpose;

    public function __construct(?ChitNumber $number, Date $date, ?Recipient $recipient, Amount $amount, string $purpose)
    {
        $this->number    = $number;
        $this->date      = $date;
        $this->recipient = $recipient;
        $this->amount    = $amount;
        $this->purpose   = $purpose;
    }

    public function withoutChitNumber() : self
    {
        return new self(null, $this->date, $this->recipient, $this->amount, $this->purpose);
    }

    public function getNumber() : ?ChitNumber
    {
        return $this->number;
    }

    public function getDate() : Date
    {
        return $this->date;
    }

    public function getRecipient() : ?Recipient
    {
        return $this->recipient;
    }

    public function getAmount() : Amount
    {
        return $this->amount;
    }

    public function getPurpose() : string
    {
        return $this->purpose;
    }

    public function equals(ChitBody $other) : bool
    {
        return (string) $other->number ===  (string) $this->number
            && $other->date->eq($this->date)
            && (string) $other->recipient === (string) $this->recipient
            && $other->amount->getExpression() === $this->amount->getExpression()
            && $other->purpose === $this->purpose;
    }
}