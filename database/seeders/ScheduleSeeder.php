<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{

    public function run(): void
    {
        $schedule1 = Schedule::create([
            'shift_name' => 'Bebas SF 1',
            'location_id' => 1,
            'start_time' => '08:00:00',
            'end_time' => '22:00:00',
        ]);

        $schedule2 = Schedule::create([
            'shift_name' => 'Bebas SF 2',
            'location_id' => 2,
            'start_time' => '08:00:00',
            'end_time' => '22:00:00',
        ]);

        $users = User::whereIn('id', [1, 2])->get();

        foreach ($users as $user) {
            DB::table('schedule_user')->insert([
                ['schedule_id' => $schedule1->id, 'user_id' => $user->id],
                ['schedule_id' => $schedule2->id, 'user_id' => $user->id],
            ]);
        }
    }
}
