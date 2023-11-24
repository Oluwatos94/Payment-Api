<?php

namespace PaymentApi;

enum Routes: string
{
    case Methods = 'methods';
    case Customers = 'customers';
    case Payments = 'payments';

    public function toString(): string
    {
        return match ($this) {
            Routes::Methods => 'method',
            Routes::Customers => 'customer',
            Routes::Payments => 'payment',
        };
    }
}