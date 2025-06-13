<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $userAttendance = Attendance::all();

        return view('attendance', compact('locations', 'userAttendance'));
    }


    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $locationId = $request->input('checkInLocation_id');

        $location = Location::findOrFail($locationId);

        $distance = $this->calculateDistance($lat, $lng, $location->latitude, $location->longitude);

        // Batasi radius ke 100 meter
        if ($distance > 0.1) {
            return back()->withErrors(['location' => 'Anda tidak berada di lokasi yang sesuai untuk absen.']);
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => now(),
            'status' => 'present',
            'checkInLocation_id' => $location->id,
            'checkInTime' => now(),
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

        return redirect()->back()->with('success', 'Berhasil absen masuk.');
    }




    public function checkOut(Request $request, Attendance $attendance)
    {
        $attendance->update($request->all());
        return response()->json(['message' => 'Checkout berhasil', 'attendance' => $attendance]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance; // in km
    }
}
