<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Registration extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes trait

    // Fillable columns for mass assignment
    protected $fillable = [
        'patient_detail_id',
        'service_id',
        'visit_date',
        'queue_number',
        'status',
    ];

    // Cast specific columns to desired types
    protected $casts = [
        'visit_date' => 'date',
    ];

    // Define 'deleted_at' column as a date
    protected $dates = ['deleted_at'];

    /**
     * Define a one-to-many relationship with PatientDetail.
     * A registration belongs to one patient detail.
     */
    public function patientDetail()
    {
        return $this->belongsTo(PatientDetail::class);
    }

    /**
     * Define a many-to-one relationship with Service.
     * A registration is associated with one service type.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Define a one-to-one relationship with Queue.
     * Each registration has one queue entry.
     */
    public function queue()
    {
        return $this->hasOne(Queue::class);
    }
}
