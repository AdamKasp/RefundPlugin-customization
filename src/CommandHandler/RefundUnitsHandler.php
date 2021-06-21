<?php

declare(strict_types=1);

namespace App\CommandHandler;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use App\Command\RefundUnits;
use App\Event\UnitsRefunded;
use Sylius\RefundPlugin\Refunder\RefunderInterface;
use Sylius\RefundPlugin\Validator\RefundUnitsCommandValidatorInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class RefundUnitsHandler
{
    /** @var RefunderInterface */
    private $orderUnitsRefunder;

    /** @var RefunderInterface */
    private $orderShipmentsRefunder;

    /** @var MessageBusInterface */
    private $eventBus;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var RefundUnitsCommandValidatorInterface */
    private $refundUnitsCommandValidator;

    public function __construct(
        RefunderInterface $orderUnitsRefunder,
        RefunderInterface $orderShipmentsRefunder,
        MessageBusInterface $eventBus,
        OrderRepositoryInterface $orderRepository,
        RefundUnitsCommandValidatorInterface $refundUnitsCommandValidator
    ) {
        $this->orderUnitsRefunder = $orderUnitsRefunder;
        $this->orderShipmentsRefunder = $orderShipmentsRefunder;
        $this->eventBus = $eventBus;
        $this->orderRepository = $orderRepository;
        $this->refundUnitsCommandValidator = $refundUnitsCommandValidator;
    }

    public function __invoke(RefundUnits $command): void
    {
        $this->refundUnitsCommandValidator->validate($command);

        $orderNumber = $command->orderNumber();

        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneByNumber($orderNumber);

        $refundedTotal = 0;
        $refundedTotal += $this->orderUnitsRefunder->refundFromOrder($command->units(), $orderNumber);
        $refundedTotal += $this->orderShipmentsRefunder->refundFromOrder($command->shipments(), $orderNumber);

        /** @var string|null $currencyCode */
        $currencyCode = $order->getCurrencyCode();
        Assert::notNull($currencyCode);

        $this->eventBus->dispatch(new UnitsRefunded(
            $orderNumber,
            $command->units(),
            $command->shipments(),
            $command->paymentMethodId(),
            $refundedTotal,
            $currencyCode,
            $command->comment(),
            $command->getFutureDate()
        ));
    }
}
