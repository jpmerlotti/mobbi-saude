<?php

namespace App\Enums;

enum SupportStatus: string
{
    case PENDING = 'pending';
    case CLOSED = 'closed';
    case CANCELED = 'canceled';
}
