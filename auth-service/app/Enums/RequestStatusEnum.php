<?php
namespace App\Enums;

enum RequestStatusEnum: string
{
    case Sended = 'sended';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}
