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

use Sylius\RefundPlugin\Entity\RefundPaymentInterface as baseRefundPaymentInterface;

interface RefundPaymentInterface extends baseRefundPaymentInterface
{
    public function getFuturePaymentDate(): \DateTime;

    public function setFuturePaymentDate(\DateTime $date): void;
}
