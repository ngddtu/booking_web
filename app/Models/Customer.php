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
        'email',
        'address', 
        'status'
    ]; 

    public function filter_customsers($filters){
        $query = $this->newQuery();
        if(isset($filters['phone'])){
            $query->where('phone', 'like', '%' . $filters['phone'] . '%');
        }
        return $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
    }
}
