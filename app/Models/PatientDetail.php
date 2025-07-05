<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;
    // PatientDetail tidak perlu SoftDeletes karena penghapusan User akan meng-cascade PatientDetail

    protected $fillable = [
        'user_id',
        'nik',
        'address',
        'birth_date',
        'phone_number',
        'gender',
        'bpjs_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'bpjs_status' => 'boolean',
    ];

    /**
     * Get the user that owns the patient detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // WAJIB: Pastikan ini adalah definisi standar
    }

    /**
     * Get the registrations for the patient.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the patient visits for the patient.
     */
    public function patientVisits()
    {
        return $this->hasMany(PatientVisit::class);
    }
}
