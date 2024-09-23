<?php

namespace App\Livewire\Form;

use Livewire\Form;

class PersonaForm extends Form
{
    public $cargo_id;
    public $nombre;
    public $apellido; // Asegúrate de incluir el apellido en las propiedades
    public $salario;
    public $estado;
    public $foto; // Asegúrate de incluir foto en las propiedades
    public $direccion; // Asegúrate de incluir dirección en las propiedades
    public $telefono;
    
    // Validación de reglas
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'salario' => 'nullable|numeric|min:0', // Validación para salario
            'foto' => 'nullable|string', // Aquí puedes cambiar a 'nullable|image' si deseas validar imágenes
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'required|numeric|min:10000000', // Asegúrate de definir un rango válido para el teléfono
        ];
    }
    
    // Validación personalizada
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'salario.numeric' => 'El campo salario debe ser un número.',
            'salario.min' => 'El salario debe ser un valor positivo.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.numeric' => 'El campo teléfono debe ser un número.',
            'telefono.min' => 'El número de teléfono debe tener al menos 8 dígitos.', // Ajusta según tu necesidad
            'foto.image' => 'La foto debe ser una imagen válida.', // Si cambiaste a 'image'
        ];
    }
    

}
