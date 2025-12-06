<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoom extends Model
{
    /** @use HasFactory<\Database\Factories\TypeRoomFactory> */
    use HasFactory;


    protected $table = 'room_types';

    protected $fillable = [
        'name',
        'description',
        'initial_hour_rate',
        'overnight_rate',
        'daily_rate',
        'late_checkout_fee_value',
        'max_people',
        'status',
    ];
    //filter trang danh sách loại phòng
    public function scopeFilter($filters)
    {
        $query = $this->newQuery(); // Khởi tạo query builder từ TypeRoom

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['people'])) {
            $query->where('max_people', $filters['people']);
        }

        // Nếu muốn đếm số rooms liên quan cho mỗi TypeRoom
        $query->withCount('rooms');

        return $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
    }



    //thêm mới loại phongf
    public function store_new_type_room(array $data)
    {
        $this->create($data);
    }

    public function update_type_room($id, array $data)
{
    $typeRoom = $this->find($id);

    $oldStatus = $typeRoom->status;

    $typeRoom->update($data);

    $newStatus = $data['status'] ?? $oldStatus;

    // Nếu chuyển từ available -> locked
    if($oldStatus === 'available' && $newStatus === 'disable') {

        // update các phòng không occupied
        $typeRoom->rooms()
            ->whereNotIn('status', ['occupied'])
            ->update(['status' => 'disable']);
    }

    return true;
}


    //hàm lấy loại phòng
    public function getTypeRoom() {
        $typeRoom = $this->where('status','available')->get();
        return $typeRoom;
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}
