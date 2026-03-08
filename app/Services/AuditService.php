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

        $changes = $model->getChanges();

        // Ignore timestamp updates
        unset($changes['updated_at']);

        $oldValues = array_intersect_key($model->getOriginal(), $changes);

        return AuditLog::create([
            'batch_id'   => static::$batchId,
            'user_id'    => auth()->id(),
            'action'     => $action,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->id,
            'old_values' => $action === 'updated' ? $oldValues : null,
            'new_values' => $action === 'updated' ? $changes : $model->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}