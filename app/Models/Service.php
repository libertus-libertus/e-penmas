<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi: Jenis Pelayanan (Service) memiliki banyak Jadwal Layanan (ServiceSchedule).
     */
    public function serviceSchedules()
    
    {
        return $this->hasMany(ServiceSchedule::class);
    }


    /**
     * Relasi: Jenis Pelayanan memiliki banyak Pendaftaran.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}