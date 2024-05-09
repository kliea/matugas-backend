<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cart_id';

    /**
     * attributes DILI pwede hilabtan.
     *
     * @var array
     */
    protected $guarded = ['cart_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }

    /**
     * di apilon ang timestamps
     *
     * @var string
     */
    public $timestamps = false;
}
