<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    // Fillable columns for mass assignment
    protected $fillable = [
        'registration_id',
        'queue_number', // This column will be populated from registration.queue_number
        'status',
    ];

    /**
     * Define a one-to-one relationship with Registration.
     * A queue entry belongs to one registration.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
