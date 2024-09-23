<?php

namespace App\Livewire\Form;

use Livewire\Form;

class CargoForm extends Form
{
    public $cargo_id;
    public $nombre;
    public $salario;
    public $estado;

   // Validación de reglas
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'salario' => 'nullable|numeric|min:0', // Validación para salario
        ];
    }

    // Validación personalizada
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'salario.numeric' => 'El campo salario debe ser un número.',
            'salario.min' => 'El salario debe ser un valor positivo.',
        ];

        
    }
}
