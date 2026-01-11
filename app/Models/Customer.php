<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Reservation;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['id','address','phone'];
    public $incrementing = false;
    protected $primaryKey = 'id';

    
    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

     public function reservations() {
        return $this->hasMany(Reservation::class, 'customer_id');
    }
}
