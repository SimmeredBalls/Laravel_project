<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'invoice_number',
        'total_amount',
        'issued_at',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
