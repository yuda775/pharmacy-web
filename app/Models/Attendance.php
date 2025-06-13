<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function checkInLocation()
    {
        return $this->belongsTo(Location::class, 'check_in_location_id');
    }
    public function checkOutLocation()
    {
        return $this->belongsTo(Location::class, 'check_out_location_id');
    }
}
