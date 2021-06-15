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

namespace App\Factory;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\RefundPlugin\Entity\RefundPaymentInterface;
use Sylius\RefundPlugin\Factory\RefundPaymentFactoryInterface;

final class RefundPaymentFactory implements RefundPaymentFactoryInterface
{
    /** @var RefundPaymentFactoryInterface */
    private $baseRefundPaymentFactory;

    public function __construct($baseRefundPaymentFactory)
    {
        $this->baseRefundPaymentFactory = $baseRefundPaymentFactory;
    }

    public function createWithData(
        OrderInterface $order,
        int $amount,
        string $currencyCode,
        string $state,
        int $paymentMethodId
    ): RefundPaymentInterface {
        return $this->baseRefundPaymentFactory->createWithData($order, $amount, $currencyCode, $state, $paymentMethodId);
    }

    public function createWithDataAndDate(
        OrderInterface $order,
        int $amount,
        string $currencyCode,
        string $state,
        int $paymentMethodId,
        \DateTime $date
    ): RefundPaymentInterface {
        /** @var RefundPaymentInterface $refundPayment */
        $refundPayment = $this->baseRefundPaymentFactory->createWithData($order, $amount, $currencyCode, $state, $paymentMethodId);
        $refundPayment->setFuturePaymentDate($date);

        return $refundPayment;
    }
}

