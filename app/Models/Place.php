<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Owner;
use App\Models\Reservation;

class Place extends Model {
    use HasFactory;

    protected $fillable = ['owner_id','name','description','location','price_per_day','capacity','images','rating','available_from','available_to'];

    public function owner() {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'hall_id');
    }
}
