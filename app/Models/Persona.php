<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';
    protected $fillable = ['nombre','apellido','foto','direccion','telefono','estado'];

    public function vendedor()
    {
        return $this->hasOne(Vendedor::class, 'id_persona');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_persona');
    }
}
