<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::query();
        
        // Filtro por módulo si se especifica
        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }
        
        // Filtro por fecha si se especifica
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }
        
        // Ordenar por fecha descendente (más recientes primero)
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('system-logs.index', compact('logs'));
    }
}
