<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerTransaction extends Model
{
    protected $table = 'partner_transactions';
    protected $fillable = [
        'user_id',
        'credit',
        'debit',
        'balance',
        'amount',
        'status',
        'remark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
