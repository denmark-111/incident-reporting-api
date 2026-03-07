<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Str;

class AuditService
{
    protected static $batchId;

    public static function log($model, $action)
    {
        // Ensure one Batch ID per request cycle
        static::$batchId = static::$batchId ?? (string) Str::uuid();

        return AuditLog::create([
            'batch_id'   => static::$batchId,
            'user_id'    => auth()->id(),
            'action'     => $action,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->id,
            'old_values' => $action === 'updated' ? $model->getOriginal() : null,
            'new_values' => $action === 'updated' ? $model->getChanges() : $model->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}