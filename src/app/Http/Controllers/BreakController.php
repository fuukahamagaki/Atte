<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;
use App\Http\Controllers\WorkController;

class BreakController extends Controller
{
    public function breakStart()
    {
        //ID取得
        $userId = Auth::user()->id;

        //ユーザーに関連する最新の休憩レコードを取得
        $latestBreak = Rest::where('work_id', $userId)->latest()->first();

        //最新の休憩レコードが存在しないか、既に休憩開始されている場合
        if (!$latestBreak || $latestBreak->breakEnd){
            $break = Rest::create([
                'work_id' => $userId,
                'breakStart' => Carbon::now(),
            ]);

            return redirect()->back()->with('my_status', '休憩を開始しました');
        }

        //既に休憩開始がされている場合
        return redirect()->back()->with('my_status', '既に休憩中です');
    }

    public function breakEnd()
    {
        $userId = auth()->user()->id;

        $work = Work::where('user_id',$userId)->first();

        //ユーザーに関連する作業データが存在しない場合
        if (!$work) {
            return redirect()->back()->with('my_status', '作業データが見つかりません');
        }

        //最新の休憩データを取得
        $latestRest = $work->rests()->latest()->first();

        //最新の休憩データが存在しない場合
        if (!$latestRest) {
            return redirect()->back()->with('my_status', '休憩データが見つかりません');
        }

        $latestRest->update([
            'breakEnd' => Carbon::now(),
        ]);

        return redirect()->back()->with('my_status', '休憩を終了しました');
    }
}
