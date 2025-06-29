<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'patient_detail_id',
        'service_id',
        'visit_date',
        'queue_number',
        'status',
    ];

    // Mengubah tipe data untuk kolom tertentu jika diperlukan
    protected $casts = [
        'visit_date' => 'date',
    ];

    // Tentukan kolom 'deleted_at' sebagai tanggal
    protected $dates = ['deleted_at'];

    /**
     * Definisi relasi One-to-Many dengan PatientDetail.
     * Sebuah pendaftaran dimiliki oleh satu detail pasien.
     */
    public function patientDetail()
    {
        return $this->belongsTo(PatientDetail::class);
    }

    /**
     * Definisi relasi Many-to-One dengan Service.
     * Sebuah pendaftaran terkait dengan satu jenis layanan.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Definisi relasi One-to-One dengan Queue.
     * Setiap pendaftaran memiliki satu antrean.
     */
    public function queue()
    {
        return $this->hasOne(Queue::class);
    }

    /**
     * Definisi relasi One-to-One dengan Appointment.
     * Setiap pendaftaran dapat memiliki satu catatan pelayanan.
     * WAJIB: Relasi ini ditambahkan untuk menyelesaikan error.
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
