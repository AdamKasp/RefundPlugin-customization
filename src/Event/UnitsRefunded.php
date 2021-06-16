<?php

declare(strict_types=1);

namespace App\Event;

use Sylius\RefundPlugin\Event\UnitsRefunded as baseUnitsRefunded;

class UnitsRefunded extends baseUnitsRefunded
{
    /** @var \DateTime */
    public $futureDate;

    public function __construct(
        string $orderNumber,
        array $units,
        array $shipments,
        int $paymentMethodId,
        int $amount,
        string $currencyCode,
        string $comment,
        \DateTime $futureDate
    ) {
        parent::__construct($orderNumber, $units, $shipments, $paymentMethodId, $amount, $currencyCode, $comment);
        $this->futureDate = $futureDate;
    }

    public function getFutureDate(): \DateTime
    {
        return $this->futureDate;
    }
}
