<?php

namespace App\Livewire\Form;

use Livewire\Form;

class VendedorForm extends Form
{
    public $id_persona;
    public $id_cargo;
    public $estado;

    public function rules()
    {
        return [
            'id_persona' => 'required|exists:persona,id', 
            'id_cargo' => 'required|exists:cargo,id', 
        ];
    }

    public function messages()
    {
        return [
            'id_persona.required' => 'El campo id_persona es obligatorio.',
            'id_persona.exists' => 'El id_persona debe existir en la tabla de personas.',
            'id_cargo.required' => 'El campo id_cargo es obligatorio.',
            'id_cargo.exists' => 'El id_cargo debe existir en la tabla de cargos.',
        ];
    }

}
