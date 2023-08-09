<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Work;

class WorkController extends Controller
{
    public function index ()
    {
        return view('index');
    }

    public function workStart()
    {
        $user = Auth::user();
        
        $oldTimestamp = Work::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldTimestampWorkStart = new Carbon($oldTimestamp->workStart);
            $oldTimestampDay = $oldTimestampWorkStart->startOfDay();
        } else {
            $timestamp = Work::create([
                'user_id' => $user->id,
                'workStart' => Carbon::now(),
            ]);

            return redirect()->back()->with('my_status', '出勤打刻が完了しました');

        }

        $newTimestampDay = Carbon::today();

        $timestamp = Work::create([
            'user_id' => $user->id,
            'workStart' => Carbon::now(),
        ]);

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');
    }

    public function workEnd()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        if( !empty($timestamp->workEnd)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        $timestamp->update([
            'workEnd' => Carbon::now()
        ]);

        return redirect()->back()->with('my_status', '退勤打刻が完了しました');
    }
}
