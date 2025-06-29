<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_detail_id',
        'service_id',
        'visit_date',
        'status', // e.g., 'completed', 'cancelled'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Get the patient detail associated with the patient visit.
     */
    public function patientDetail()
    {
        return $this->belongsTo(PatientDetail::class);
    }

    /**
     * Get the service associated with the patient visit.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
