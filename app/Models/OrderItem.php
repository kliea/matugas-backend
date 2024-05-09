<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'order_item_id';

    /**
     * attributes DILI pwede hilabtan.
     *
     * @var array
     */
    protected $guarded = ['order_item_id'];

    public function cart()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    /**
     * di apilon ang timestamps
     *
     * @var string
     */
    public $timestamps = false;
}
