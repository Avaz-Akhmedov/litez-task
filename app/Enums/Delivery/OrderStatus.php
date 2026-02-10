<?php

namespace App\Enums\Delivery;

enum OrderStatus : string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case In_delivery = 'in_delivery';
    case Delivery = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Создан, ожидает оплаты',
            self::Paid => 'Оплачен',
            self::In_delivery => 'В пути',
            self::Delivery => 'Доставлен',
            self::Cancelled => 'Отменён',
        };
    }

    public function canTransitionTo(OrderStatus $nextStatus): bool
    {
        return match($this) {
            self::Pending => in_array($nextStatus, [self::Paid, self::Cancelled]),
            self::Paid => in_array($nextStatus, [self::In_delivery, self::Cancelled]),
            self::In_delivery => in_array($nextStatus, [self::Delivery, self::Cancelled]),
            self::Delivery, self::Cancelled => false,
        };
    }
}
