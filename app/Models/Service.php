<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel jika tidak sesuai dengan konvensi Laravel (plural dari nama model)
    protected $table = 'services';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'description',
    ];
}