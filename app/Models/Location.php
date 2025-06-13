<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function attendancesIn()
    {
        return $this->hasMany(Attendance::class, 'check_in_location_id');
    }
    public function attendancesOut()
    {
        return $this->hasMany(Attendance::class, 'check_out_location_id');
    }
}
