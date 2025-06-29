<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;

    protected $table = 'patient_details';

    protected $fillable = [
        'user_id',
        'nik',
        'address',
        'birth_date', // Kolom ini yang perlu di-cast
        'phone_number',
        'gender',
        'bpjs_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date', // <-- TAMBAHKAN ATAU UBAH INI
        'bpjs_status' => 'boolean', // Rekomendasi: cast boolean juga untuk konsistensi
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Detail Pasien memiliki banyak Pendaftaran.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the patient visits for the patient.
     * WAJIB: Relasi ini ditambahkan untuk menyelesaikan error.
     */
    public function patientVisits()
    {
        return $this->hasMany(PatientVisit::class);
    }
}