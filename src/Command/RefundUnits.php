<?php

declare(strict_types=1);

namespace App\Command;

use Sylius\RefundPlugin\Command\RefundUnitsInterface;
use Sylius\RefundPlugin\Command\RefundUnits as baseRefundUnits;

final class RefundUnits extends baseRefundUnits implements RefundUnitsInterface
{
    /** @var \DateTime|null */
    private $futureDate;

    public function __construct(
        string $orderNumber,
        array $units,
        array $shipments,
        int $paymentMethodId,
        string $comment,
        ?\DateTime $futureDate
    ) {
        parent::__construct($orderNumber, $units, $shipments, $paymentMethodId, $comment);
        $this->futureDate = $futureDate;
    }

    public function getFutureDate(): ?\DateTime
    {
        return $this->futureDate;
    }

    public function setFutureDate(?\DateTime $futureDate): void
    {
        $this->futureDate = $futureDate;
    }
}
