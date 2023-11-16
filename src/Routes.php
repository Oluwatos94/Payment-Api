<?php

namespace PaymentApi;

enum Routes: string
{
    case Methods = 'methods';
    case Customers = 'customers';
    case Payments = 'payments';
    case Baskets = 'baskets';

    public function toString(): string
    {
        return match ($this) {
            Routes::Methods => 'method',
            Routes::Customers => 'customer',
            Routes::Payments => 'payment',
            Routes::Baskets => 'basket'
        };
    }
}