<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
    /**
     * attributes DILI pwede hilabtan.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'created_at', 'updated_at'];

    public function hasRole(string $role): bool
    {
        // Adjust this logic based on how you store roles
        return $this->role === $role;
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'store_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
