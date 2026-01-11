<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Place;

class Owner extends Model {
    use HasFactory;

    public $timestamps = false; // Owners table doesn't have timestamps columns
    
    protected $fillable = ['id','phone','company_name'];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }

    public function places() {
        return $this->hasMany(Place::class, 'owner_id');
    }
}

