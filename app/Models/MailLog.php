<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    use HasFactory;

    const EVENT_ACCEPTED = 'Accepted';
    const EVENT_DELIVERED = 'Delivered';
    const EVENT_OPENED = 'Opened';
    const EVENT_REJECTED = 'Rejected';
    const EVENT_COMPLAINED = 'Complained';
    const EVENT_TEMPORARY_FAIL = 'Temporary Fail';
    const EVENT_PERMANENT_FAIL = 'Permanent Fail';

    public static array $events = [
        self::EVENT_ACCEPTED,
        self::EVENT_DELIVERED,
        self::EVENT_OPENED,
        self::EVENT_REJECTED,
        self::EVENT_COMPLAINED,
        self::EVENT_TEMPORARY_FAIL,
        self::EVENT_PERMANENT_FAIL,
    ];
}
