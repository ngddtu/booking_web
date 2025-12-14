<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'gender',
        'nationality',
        'citizen_id',
        'rank',
        'note',
        'status'
    ]; 

    public function filter_customsers($filters){
        $query = $this->newQuery();
        if(isset($filters['phone'])){
            $query->where('phone', 'like', '%' . $filters['phone'] . '%');
        }
        return $query->withCount('bookings')->withSum('bookings', 'total_price')->orderBy('id', 'desc')->paginate(8)->withQueryString();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
