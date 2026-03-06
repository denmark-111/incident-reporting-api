<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $appointment = $this->route('appointment');

        return [

            'scheduled_at' => [
                'sometimes',
                'date',
                'after:now',
                function ($attribute, $value, $fail) use ($appointment) {

                    $time = Carbon::parse($value);

                    // Check operating hours
                    if ($time->hour < 7 || $time->hour >= 17) {
                        $fail('Appointments must be between 7AM and 5PM.');
                        return;
                    }

                    $start = $time->copy()->startOfHour();
                    $end   = $time->copy()->endOfHour();

                    $exists = Appointment::whereBetween('scheduled_at', [$start, $end])
                        ->where('id','!=',$appointment->id)
                        ->exists();

                    if ($exists) {
                        $fail('This appointment slot is already taken.');
                    }
                }
            ],

            'status' => [
                'sometimes',
                'in:scheduled,rescheduled,completed,cancelled,no-show'
            ]
        ];
    }
}
