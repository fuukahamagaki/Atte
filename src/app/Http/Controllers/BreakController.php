<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Http\Controllers\WorkController;

class BreakController extends Controller
{
    public function breakStart()
    {
        $work = Rest::work();

        // $timestamp = Rest::create([
        //     'work_id' => $work->id,
        //     'breakStart' => Carbon::now(),
        // ]);

        // return redirect()->back()->with('my_status', '休憩を開始しました');


        $newTimestampDay = Carbon::today();

        $timestamp = Rest::create([
            'work_id' => $work->id,
            'breakStart' => Carbon::now(),
        ]);

        return redirect()->back()->with('my_status', '休憩を開始しました');
    }

    public function breakEnd()
    {
        $work = Work::work();
        $timestamp = Rest::where('work_id', $work->id)->latest()->first();

        $timestamp->update([
            'breakEnd' => Carbon::now()
        ]);

        return redirect()->back()->with('my_status', '休憩を終了しました');
    }
}
