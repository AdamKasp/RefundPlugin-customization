<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\RefundPlugin\Entity\RefundPayment as baseRefundPayment;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_refund_refund_payment")
 */
final class RefundPayment extends baseRefundPayment implements RefundPaymentInterface
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable="true", name="future_payment_date")
     */
    protected $futurePaymentDate;

    public function getFuturePaymentDate(): \DateTime
    {
        return $this->futurePaymentDate;
    }

    public function setFuturePaymentDate(\DateTime $futurePaymentDate): void
    {
        $this->futurePaymentDate = $futurePaymentDate;
    }
}
