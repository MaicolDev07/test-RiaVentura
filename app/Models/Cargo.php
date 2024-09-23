<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargo';
    protected $fillable = ['nombre','salario','estado'];

    public function vendedores()
    {
        return $this->hasMany(Vendedor::class, 'id_cargo');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_cliente');
    }
}
