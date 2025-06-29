<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // We might consider soft deletes for appointments later if needed for history

class Appointment extends Model
{
    use HasFactory, SoftDeletes; // No SoftDeletes for now as per current requirements, but keep in mind for future

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_id',
        'user_id', // Refers to the staff/admin who provided the service
        'service_id',
        'notes',
    ];

    /**
     * Get the registration that owns the appointment.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the user (staff/admin) who provided the service.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // This refers to the 'users' table
    }

    /**
     * Get the service associated with the appointment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
