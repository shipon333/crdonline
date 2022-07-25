<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    public function device_type(){
        return $this->belongsTo(DeviceType::class,'device_type_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
