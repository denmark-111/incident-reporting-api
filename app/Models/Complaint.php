<?php

namespace App\Models;

use App\Services\Notifier;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;

    use Auditable;

    protected $fillable = [
        'incident_date',
        'incident_time',
        'location',
        'latitude',
        'longitude',
        'type',
        'severity',
        'description',
        'complainant_name',
        'complainant_contact',
        'respondent_name',
        'respondent_address',
        'desired_resolution',
        'evidence_path',
        'additional_notes',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function witnesses()
    {
        return $this->hasMany(Witness::class);
    }

    public function appointments()
    {
        return $this->morphMany(Appointment::class, 'reference');
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
                'reference_type' => Complaint::class,
                'reference_id' => $model->id,
                'user_id' => auth()->id(),
                'event_type' => 'complaint_created',
                'message' => 'Complaint created',
            ]);
        });

        static::updated(function ($model) {
            if ($model->wasChanged('status')) {
                $originalStatus = $model->getOriginal('status');
                $newStatus = $model->status;

                CaseUpdate::create([
                    'reference_type' => Complaint::class,
                    'reference_id' => $model->id,
                    'user_id' => auth()->id(),
                    'event_type' => 'status_change',
                    'old_status' => $originalStatus,
                    'new_status' => $newStatus,
                    'message' => "Status changed from {$originalStatus} to {$newStatus}",
                ]);

                Notifier::send(
                    $model->user->id,
                    'complaint_status_updated',
                    "Your complaint status has been updated to {$newStatus}",
                    [
                        'complaint_id' => $model->id,
                        'old_status' => $originalStatus,
                        'new_status' => $newStatus,
                    ]
                );
            }
        });
    }
}
