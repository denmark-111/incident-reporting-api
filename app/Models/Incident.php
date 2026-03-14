<?php

namespace App\Models;

use App\Services\Notifier;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    use Auditable;

    protected $fillable = [
        'description',
        'evidence_path',
        'location',
        'latitude',
        'longitude',
        'additional_notes',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function types()
    {
        return $this->belongsToMany(IncidentType::class, 'incident_incident_type');
    }

    public function customFieldValues()
    {
        return $this->hasMany(CustomFieldValue::class);
    }

    public function caseUpdates()
    {
        return $this->morphMany(CaseUpdate::class, 'reference');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            CaseUpdate::create([
                'reference_type' => Incident::class,
                'reference_id' => $model->id,
                'user_id' => auth()->id(),
                'event_type' => 'incident_created',
                'message' => 'Incident created',
            ]);
        });

        static::updated(function ($model) {
            if ($model->wasChanged('status')) {
                $originalStatus = $model->getOriginal('status');
                $newStatus = $model->status;

                CaseUpdate::create([
                    'reference_type' => Incident::class,
                    'reference_id' => $model->id,
                    'user_id' => auth()->id(),
                    'event_type' => 'status_change',
                    'old_status' => $originalStatus,
                    'new_status' => $newStatus,
                    'message' => "Status changed from {$originalStatus} to {$newStatus}",
                ]);

                Notifier::send(
                    $model->user->id,
                    'incident_status_updated',
                    "Your incident report status has been updated to {$newStatus}",
                    [
                        'incident_id' => $model->id,
                        'old_status' => $originalStatus,
                        'new_status' => $newStatus,
                    ]
                );
            }
        });
    }
}
