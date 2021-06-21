<?php

declare(strict_types=1);

namespace App\Entity;

use Sylius\RefundPlugin\Entity\RefundPaymentInterface as baseRefundPaymentInterface;

interface RefundPaymentInterface extends baseRefundPaymentInterface
{
    public function getFuturePaymentDate(): ?\DateTime;

    public function setFuturePaymentDate(\DateTime $date): void;
}
