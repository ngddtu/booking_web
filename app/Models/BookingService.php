<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $tableName = 'booking_service';
    protected $fillable = [
        'booking_id',
        'service_id',
        'quantity'
    ];

    public function service() {
        return $this->belongsTo(RoomService::class, 'service_id');
    }
}
