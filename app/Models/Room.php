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


    //lọc phòng
    public function filterRooms($filters)
    {
        $query = $this->newQuery()->with('roomType');
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
        return match ($this->status) {
            'available'   => 'success',
            'booked'      => 'primary',
            'maintenance' => 'warning',
            'cleaning'    => 'info',
            'disable'     => 'secondary',
            'occupied'    => 'danger',
            default       => 'dark'
        };
    }


    public function update_room($id, array $data)
    {
        $room = $this->find($id);
        // if($this->rooms()->count() > 0){
        //     return 'Đang có phòng liên kết';
        // }
        $room->update($data);
    }


    public static function listWithActiveBooking(array $filters = [])
    {
        // Bắt đầu query builder từ Room
        $query = self::query()
            ->with('roomType')
            ->with([
                'activeBooking' => function ($q) {
                    $q->select('id', 'room_id', 'customer_id', 'status', 'total_price', 'check_in', 'check_out', 'status', 'rent_type');
                },
                'activeBooking.customer' => function ($q) {
                    $q->select('id', 'name', 'phone', 'address');
                },
                'activeBooking.booking_service.service' => function ($q) {
                    $q->select('id', 'name', 'price');
                },
                'activeBookings'
            ]);

        // filters: ví dụ room_number, status, type_room_id
        if (!empty($filters['room_number'])) {
            $query->where('room_number', 'like', '%' . $filters['room_number'] . '%');
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['type_room_id'])) {
            $query->where('room_type_id', $filters['type_room_id']);
        }

        // phân trang hoặc get()
        return $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
    }

    //lấy ra tổng tiền services
    public function getServicePriceAttribute()
    {
        if (!$this->activeBooking) return 0;

        return $this->activeBooking->booking_service->sum(function ($bs) {
            return $bs->quantity * $bs->service->price;
        });
    }

    //lấy ra tổng tiền
    public function getTotalPriceAttribute()
    {
        $roomPrice = $this->activeBooking->total_price ?? 0;
        return $roomPrice + $this->service_price;
    }

    //lấy ra list services
    public function getServiceListAttribute()
    {
        if (!$this->activeBooking) return [];

        return $this->activeBooking->booking_service->map(fn($bs) => [
            'name' => $bs->service->name,
            'price' => $bs->service->price
        ]);
    }

    // public function primaryActiveBooking()
    // {
    //     return $this->hasOne(Booking::class, 'room_id')
    //         ->where('status', 'confirmed')
    //         ->orderBy('check_in'); // booking tới sớm nhất
    // }


    public function roomType()
    {
        return $this->belongsTo(TypeRoom::class, 'room_type_id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

    public function activeBooking()
    {
        return $this->hasOne(Booking::class, 'room_id')->whereIn('status', ['confirmed']);
    }

    public function activeBookings()
{
    return $this->hasMany(Booking::class, 'room_id')
        ->whereIn('status', ['pending'])
        ->orderBy('check_in', 'asc');
}

}
