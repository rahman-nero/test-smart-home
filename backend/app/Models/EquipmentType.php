<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class EquipmentType extends Authenticatable
{
    protected $table = 'equipment_type';
    protected $fillable = [
        'title',
        'mask',
    ];

    protected $hidden = ['updated_at'];

}
