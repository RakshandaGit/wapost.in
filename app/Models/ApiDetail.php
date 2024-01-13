<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed name
 * @method static where(string $string, string $uid)
 */
class ApiDetail extends Model
{
    protected $table = 'api_details';

    protected $fillable = [
        'username',
        'password',
        'sendername',
        'routetype',
        'user_id'
    ];
}
