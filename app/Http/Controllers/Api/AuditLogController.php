<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a paginated listing of audit logs.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'This action is unauthorized.');
        
        $request->validate([
            'action'        => ['sometimes', 'string'],
            'user_id'       => ['sometimes', 'integer'],
            'batch_id'      => ['sometimes', 'string'],
            'start_date'    => ['sometimes', 'date'],
            'end_date'      => ['sometimes', 'date', 'after_or_equal:start_date'],
            'per_page'      => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $query = AuditLog::with('user')->orderByDesc('created_at');

        $query->when($request->action, fn($q) => $q->where('action', $request->action));
        $query->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id));
        $query->when($request->batch_id, fn($q) => $q->where('batch_id', $request->batch_id));
        $query->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date));
        $query->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date));

        $perPage = $request->per_page ?? 50;

        $paginated = $query->paginate($perPage)
            ->appends($request->only([
                'action', 'user_id', 'batch_id', 'start_date', 'end_date', 'per_page'
            ]));

        return AuditLogResource::collection($paginated);
    }

    /**
     * Display a single audit log.
     */
    public function show(AuditLog $auditLog)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'This action is unauthorized.');
        
        return new AuditLogResource($auditLog->load('user'));
    }
}
