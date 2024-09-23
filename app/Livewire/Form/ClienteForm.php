<?php

namespace App\Livewire\Form;

use Livewire\Form;

class ClienteForm extends Form
{
    public $id_persona;
    public $id_cargo;
    public $estado;

    public function rules()
    {
        return [
            'id_persona' => 'required|exists:persona,id', 
            'id_cargo' => 'required|exists:cargo,id', 
            'estado' => 'nullable|boolean',
        ];
    }

    // Mensajes de error personalizados
    public function messages()
    {
        return [
            'id_persona.required' => 'El campo id_persona es obligatorio.',
            'id_persona.exists' => 'El id_persona debe existir en la tabla de personas.',
            'estado.boolean' => 'El campo estado debe ser verdadero o falso.',
        ];
    }
}
