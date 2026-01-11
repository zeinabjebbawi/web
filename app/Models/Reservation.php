<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Place;
use App\Models\Customer;


class Reservation extends Model {
    use HasFactory;

    protected $fillable = ['customer_id','hall_id','start_date','end_date','status','total_price'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function place() {
        return $this->belongsTo(Place::class, 'hall_id');
    }
}

