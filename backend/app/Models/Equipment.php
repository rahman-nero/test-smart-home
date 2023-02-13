<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Equipment extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'equipments';

    protected $fillable = [
        'equipment_type_id',
        'serial_number',
        'comment'
    ];

    protected $hidden = ['updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id','id');
    }
}
