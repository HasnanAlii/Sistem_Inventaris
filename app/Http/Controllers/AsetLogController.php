<?php

namespace App\Http\Controllers;

use App\Models\AsetLog;
use App\Models\Aset;
use Illuminate\Http\Request;

class AsetLogController extends Controller
{
    public function index()
{
    $logs = AsetLog::with(['aset', 'user'])->latest()->paginate(10);

    return view('aset_logs.index', compact('logs'));
}

}
