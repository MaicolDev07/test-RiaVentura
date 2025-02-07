<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $table = "visita";
    protected $fillable = [
        'id_cliente',
        'fecha',
        'hora',
        'id_contacto',
        'ubicacion_map',
        'estado',
    ];
}
