<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'inventory_id';

    /**
     * attributes DILI pwede hilabtan.
     *
     * @var array
     */
    protected $guarded = ['inventory_id'];

    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id', 'inventory_id');
    }

    /**
     * di apilon ang timestamps
     *
     * @var string
     */
    public $timestamps = false;
}
