<?php

namespace App\Http\Controllers;

use App\Models\CategoryLog;
use Illuminate\Http\Request;

class CategoryLogController extends Controller
{
    public function index()
    {
        $logs = CategoryLog::orderByDesc('created_at')->limit(100)->get();
        return response()->json($logs);
    }
}
