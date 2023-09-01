<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $workStartTime = Work::workStart();
        
        return view('list', compact('workStartTime'));
    }
}
