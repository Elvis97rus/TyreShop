<?php

namespace App\Enums;


/**
 * Class PaymentStatus
 *
 * @author
 * @package App\Enums
 */
enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
}
