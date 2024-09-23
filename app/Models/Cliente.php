<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    protected $fillable = ['id_persona','id_cargo','estado'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }
}
