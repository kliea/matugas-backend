<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
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
}
