<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index()
    {
        $logs = UserLog::orderByDesc('created_at')->limit(100)->get();
        return view('admin.admin-logs', ['logs' => $logs]);
    }
}
