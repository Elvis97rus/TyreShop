<?php

namespace App\Enums;


/**
 * Class CustomerStatus
 *
 * @author
 * @package App\Enums
 */
enum CustomerStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
}
