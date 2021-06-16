<?php

declare(strict_types=1);

namespace App\Factory;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use App\Entity\RefundPayment;
use Sylius\RefundPlugin\Entity\RefundPaymentInterface as baseRefundPaymentInterface;
use App\Entity\RefundPaymentInterface;
use Sylius\RefundPlugin\Factory\RefundPaymentFactoryInterface;

final class RefundPaymentFactory implements RefundPaymentFactoryInterface
{
    /** @var RefundPaymentFactoryInterface */
    private $baseRefundPaymentFactory;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    public function __construct($baseRefundPaymentFactory, $paymentMethodRepository)
    {
        $this->baseRefundPaymentFactory = $baseRefundPaymentFactory;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function createWithData(
        OrderInterface $order,
        int $amount,
        string $currencyCode,
        string $state,
        int $paymentMethodId
    ): baseRefundPaymentInterface {
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
        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $this->paymentMethodRepository->find($paymentMethodId);

        $payment = new RefundPayment($order, $amount, $currencyCode, $state, $paymentMethod);
        $payment->setFuturePaymentDate($date);

        return $payment;
    }
}

