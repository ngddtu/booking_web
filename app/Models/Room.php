<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
    ];

    public function filterRooms($filters)
    {
        $query = $this->newQuery()->with('typeRoom');
        if (!empty($filters['room_number'])) {
            $query->where('room_number', 'like', '%' . $filters['room_number'] . '%');
        }
        if (!empty($filters['type_id'])) {
            $query->where('room_type_id', 'like', '%' . $filters['type_id'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', 'like', '%' . $filters['status'] . '%');
        }
        return $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
    }


    public function store_new_room(array $data)
    {
        $this->create($data);
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available'   => 'Sẵn sàng',
            'booked'      => 'Đặt trước',
            'maintenance' => 'Đang bảo trì',
            'cleaning'    => 'Đang dọn dẹp',
            'disable'     => 'Bị khóa',
            'occupied'    => 'Có khách',
            default       => $this->status,
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status){
            'available'   => 'success',
            'booked'      => 'primary',
            'maintenance' => 'warning',
            'cleaning'    => 'info',
            'disable'     => 'secondary',
            'occupied'    => 'danger',
            default       => 'dark'
        };
    }

    public function typeRoom()
    {
        return $this->belongsTo(TypeRoom::class, 'room_type_id');
    }
}
