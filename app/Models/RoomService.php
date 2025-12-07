<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomService extends Model
{
    /** @use HasFactory<\Database\Factories\RoomServiceFactory> */
    use HasFactory;
    protected $table = 'services';
    protected $fillable = [
        'name',
        'description',
        'price',
        'unit',
    ];

    public function getServiceAttribute() {
        $services = RoomService::get();
        return $services;
    }
}
