<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'type'          => ['sometimes', 'string'],
            'is_read'       => ['sometimes', 'boolean'],
            'start_date'    => ['sometimes', 'date'],
            'end_date'      => ['sometimes', 'date', 'after_or_equal:start_date'],
            'per_page'      => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $user = auth()->user();

        $query = Notification::where('user_id', $user->id);

        // Filter by type
        $query->when($request->type, function ($q) use ($request) {
            $q->where('type', $request->type);
        });

        // Filter by read/unread
        $query->when($request->has('is_read'), function ($q) use ($request) {
            if ($request->is_read) {
                $q->whereNotNull('read_at');
            } else {
                $q->whereNull('read_at');
            }
        });

        // Filter by start date
        $query->when($request->start_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->start_date);
        });

        // Filter by end date
        $query->when($request->end_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->end_date);
        });

        $perPage = $request->per_page ?? 10;

        $paginated = $query->latest()
            ->paginate($perPage)
            ->appends($request->only([
                'type', 'is_read', 'start_date', 'end_date', 'per_page'
            ]));

        return NotificationResource::collection($paginated);
    }

    /**
     * Mark a notification as read.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ids'        => ['sometimes', 'array'],
            'ids.*'      => ['integer', 'exists:notifications,id'],
            'mark_all'   => ['sometimes', 'boolean'],
            'read'       => ['required', 'boolean'],
        ]);

        $query = auth()->user()->notifications();

        // If mark_all is true, then update all
        if ($request->mark_all) {
            // no additional filtering
        }
        // If specific IDs provided → filter them
        elseif ($request->filled('ids')) {
            $query->whereIn('id', $request->ids);
        }
        else {
            return response()->json([
                'message' => 'No notifications specified.'
            ], 422);
        }

        $query->update([
            'read_at' => $request->read ? now() : null
        ]);

        return response()->json([
            'message' => 'Notifications updated successfully'
        ]);
    }
}
