<?php

namespace App\Livewire\Form;

use Livewire\Form;

class VisitaForm extends Form
{
    public $id_cliente;
    public $fecha;
    public $hora;
    public $id_contacto;
    public $ubicacion_map;

    // Validación de reglas
    protected function rules()
    {
        return [
            'id_cliente' => 'required|exists:cliente,id', // Asegura que el cliente existe
            'fecha' => 'required|date', // Debe ser una fecha válida
            'hora' => 'required', // Formato de hora HH:MM
            'id_contacto' => 'required|string', // Debe ser un tipo de contacto válido
            'ubicacion_map' => 'nullable|string|max:255', // Ubicación opcional
        ];
    }

    // Validación personalizada
    public function messages()
    {
        return [
            'id_cliente.required' => 'El campo cliente es obligatorio.',
            'id_cliente.exists' => 'El cliente seleccionado no existe.',
            'fecha.required' => 'El campo fecha es obligatorio.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'hora.required' => 'El campo hora es obligatorio.',
            'id_contacto.required' => 'El campo tipo de contacto es obligatorio.',
            'id_contacto.string' => 'El tipo de contacto debe ser una cadena de texto.',
            'ubicacion_map.max' => 'La ubicación no puede tener más de 255 caracteres.',
        ];
    }


}
