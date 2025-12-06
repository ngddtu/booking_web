<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'room_id',
        'check_in',
        'check_out',
        'total_price',
        'status'
    ];

    public function index()
    {
        $query = $this->newQuery()->with(['customer', 'room']);
        $room = $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
        return $room;
    }

    // App/Models/Booking.php

    // public function scopeActive($query)
    // {
    //     $now = Carbon::now()->toDateString();
    //     return $query->whereIn('status', ['confirmed', 'checked_in'])
    //         ->whereDate('check_in', '<=', $now)
    //         ->whereDate('check_out', '>=', $now);
    // }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
