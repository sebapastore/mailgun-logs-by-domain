<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MailLog extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'domain_id',
        'mailgun_id',
        'event',
        'message_to',
        'message_from',
        'subject',
        'timestamp',
        'data'
    ];

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

    public static function getEventsForSelect(): Collection
    {
        return collect([
            ['id' => null, 'name' => 'Todos'],
            ['id' => self::EVENT_ACCEPTED, 'name' => self::EVENT_ACCEPTED],
            ['id' => self::EVENT_DELIVERED, 'name' => self::EVENT_DELIVERED],
            ['id' => self::EVENT_OPENED, 'name' => self::EVENT_OPENED],
            ['id' => self::EVENT_REJECTED, 'name' => self::EVENT_REJECTED],
            ['id' => self::EVENT_COMPLAINED, 'name' => self::EVENT_COMPLAINED],
            ['id' => self::EVENT_TEMPORARY_FAIL, 'name' => self::EVENT_TEMPORARY_FAIL],
            ['id' => self::EVENT_PERMANENT_FAIL, 'name' => self::EVENT_PERMANENT_FAIL],
        ]);
    }

}
