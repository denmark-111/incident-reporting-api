<?php

namespace App\Traits;

use App\Services\AuditService;

trait Auditable
{
    /**
     * This boot method follows Laravel's naming convention for traits:
     * boot{TraitName} will automatically run when the model starts.
     */
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            AuditService::log($model, 'created');
        });

        static::updated(function ($model) {
            // Only log if the record actually changed
            if ($model->isDirty()) {
                AuditService::log($model, 'updated');
            }
        });

        static::deleted(function ($model) {
            AuditService::log($model, 'deleted');
        });
    }
}