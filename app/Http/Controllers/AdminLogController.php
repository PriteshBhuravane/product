<?php

namespace App\Http\Controllers;

use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index()
    {
        $logs = AdminLog::orderByDesc('created_at')->limit(100)->get();
        return view('admin.admin-logs', ['logs' => $logs]);
    }
}
