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
        
        //ユーザーに関連する最新の出勤レコードを取得
        $latestTimestamp = Work::where('user_id', $user->id)->latest()->first();
        
        //最新の出勤レコードが存在しないか、すでに退勤打刻がされている場合
        if (!$latestTimestamp || $latestTimestamp->workEnd) {
            $timestamp = Work::create([
                'user_id' => $user->id,
                'workStart' => Carbon::now(),
            ]);

            return redirect()->back()->with('my_status', '出勤しました');

        }

        //既に出勤打刻がされている場合
        return redirect()->back()->with('my_status', '既に出勤しています');
    }

    public function workEnd()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        //退勤打刻が既に行われている場合、または出勤打刻がされていない場合
        if(!$timestamp || $timestamp->workEnd) {
            return redirect()->back()->with('error', '退勤の打刻ができません');
        }
        
        //退勤打刻
        $timestamp->update([
            'workEnd' => Carbon::now()
        ]);

        return redirect()->back()->with('my_status', '退勤しました');
    }
}
