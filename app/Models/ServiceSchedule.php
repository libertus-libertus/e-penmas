<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'day',
        'start_time',
        'end_time',
    ];

    /**
     * Relasi: Jadwal Layanan dimiliki oleh satu Jenis Pelayanan (Service).
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}