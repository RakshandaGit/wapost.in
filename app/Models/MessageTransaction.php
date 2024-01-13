<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTransaction extends Model
{
    protected $table = 'message_transactions';
    protected $fillable = [
        'user_id',
        'credit',
        'debit',
        'balance',
        'remark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
