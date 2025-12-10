<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');
        
        // Filter by table
        if ($request->filled('table')) {
            $query->where('nama_tabel', $request->table);
        }
        
        // Filter by operation
        if ($request->filled('operation')) {
            $query->where('operasi', $request->operation);
        }
        
        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('id_user', $request->user_id);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('timestamp', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('timestamp', '<=', $request->date_to . ' 23:59:59');
        }
        
        $logs = $query->latest('timestamp')->paginate(20);
        
        // Get users for filter
        $users = User::whereIn('role', ['admin', 'petugas'])->get();
        
        // Summary stats
        $stats = [
            'total' => LogAktivitas::count(),
            'today' => LogAktivitas::whereDate('timestamp', today())->count(),
            'this_week' => LogAktivitas::whereBetween('timestamp', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        return view('admin.log_aktivitas', compact('logs', 'users', 'stats'));
    }
}
