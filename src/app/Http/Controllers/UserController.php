<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;
use Carbon\Carbon;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $latestWorkRecord = Work::with('rests')->where('user_id', $user->id)->latest()->first();

        if ($latestWorkRecord) {
            $workStartTime = Carbon::parse($latestWorkRecord->workStart);
            $workEndTime = Carbon::parse($latestWorkRecord->workEnd);
            
            // 休憩時間の計算
            $breakTime = 0;

            foreach ($latestWorkRecord->rests as $rest) {
                $breakStart = Carbon::parse($rest->breakStart);
                $breakEnd = Carbon::parse($rest->breakEnd);
                $breakTime += $breakEnd->diffInSeconds($breakStart);
            }

            $breakHours = floor($breakTime / 3600);
            $breakMinutes = floor(($breakTime % 3600) / 60);
            $breakSeconds = $breakTime % 60;

            $breakTimeFormatted = sprintf("%02d:%02d:%02d", $breakHours, $breakMinutes, $breakSeconds);
            
            $totalWorkTime = $workEndTime->diff($workStartTime)->format('%H:%I:%S');
        } else {
            $workStartTime = null;
            $workEndTime = null;
            $breakTimeFormatted = null;
            $totalWorkTime = null;
        }

        // 全ユーザーの出退勤データを取得
        $users = User::all();

        return view('list', [
            'workStartTime' => $workStartTime,
            'workEndTime' => $workEndTime,
            'breakTimeFormatted' => $breakTimeFormatted,
            'totalWorkTime' => $totalWorkTime,
            'users' => $users,
        ]);
    }

    public function showAllUsers($date)
    {
        $users = User::whereDate('created_at', $date)->get();

        return view('list', [
            'users' => $users,
            'date' => $date,
            'workStartTime' => $workStartTime,
            'workEndTime' => $workEndTime,
            'breakTimeFormatted' => $breakTimeFormatted,
            'totalWorkTime' => $totalWorkTime,
            'allUsers' => $allUsers,
        ]);
    }

    public function myPage()
    {
        $user = Auth::user();

        return view('users.index', ['user' => $user]);
    }
}

