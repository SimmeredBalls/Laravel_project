<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'name',
        'email',
        'phone',
        'start_date',
        'end_date',
        'nights',
        'total_price',
        'status',
        'notes',
    ];


    public function room()
    {
        return $this->hasOne('App\Models\Room','id','room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

}
