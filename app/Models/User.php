<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Admin;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
 
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function owner()
    {
    return $this->hasOne(Owner::class, 'id');
    }

    public function customer() {
    return $this->hasOne(Customer::class, 'id');
    }

    public function admin() {
    return $this->hasOne(Admin::class, 'id');
    }

    public function isAdmin() {
                return $this->role === 'admin';
            }

   public function isOwner() {
                return $this->role === 'owner';
            }

     public function isCustomer() {
                return $this->role === 'customer';
            }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
