<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function device(){
        return $this->belongsTo(Device::class,'device_id','id');
    }
    public function device_type(){
        return $this->belongsTo(DeviceType::class,'device_type_id','id');
    }
}
