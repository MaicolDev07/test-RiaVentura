<?php

namespace App\Livewire;

use App\Livewire\Form\VisitaForm;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Visita;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VisitaLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchPersona;
    public $selectedPersona = false;
    public $obtenerIdPersona = "";
    public $idVisita = "";

    public $openModalNew = false;
    public $openModalEdit = false;
    public $ubicacion_map;

    public VisitaForm $visita;


    public function resetAttribute()
    {
        $this->reset(['openModalNew', 'openModalEdit', 'search','idVisita', 'searchPersona','selectedPersona','obtenerIdPersona']);
    }

    public function closeModal()
    {
        $this->resetAttribute();
        $this->resetValidation();
    }

    public function render()
    {

        $visitas = DB::table("v_visita")
                        ->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('apellido', 'like', '%' . $this->search . '%')
                        ->orderBy('id','desc')
                        ->paginate(5);

        $contactos = Contacto::all();
        $personas = collect();

        if(!empty($this->searchPersona))
        {
            $personas = Cliente::with('persona') // Cargar la relación persona
                        ->whereHas('persona', function($query) {
                            $query->where('nombre', 'like', '%' . $this->search . '%')
                                ->orWhere('apellido', 'like', '%' . $this->search . '%');
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(5);

        }

        return view('livewire.visita-livewire', compact('visitas', 'contactos','personas'));
    }

        
    public function seleccionarPersona($id)
    {
        $this->obtenerIdPersona = $id;
        $this->selectedPersona = !$this->selectedPersona;

        if(!$this->selectedPersona)
        {
            $this->reset(['obtenerIdPersona']);
        }
    }

    public function created()
    {
        $this->visita->id_cliente = $this->obtenerIdPersona;

        $this->visita->validate();
        $visita = Visita::create([
            'id_cliente' => $this->visita->id_cliente, 
            'fecha' => $this->visita->fecha, 
            'hora' => $this->visita->hora, 
            'id_contacto' => $this->visita->id_contacto, 
            'ubicacion_map' =>  $this->visita->ubicacion_map, 
        ]);

       $response = $visita ? true : false;
       $this->dispatch('notificar', message: $response);
       $this->resetAttribute();
    }

    public function edit($id)
    {
        $this->idVisita = $id;
        $visita = Visita::find($id);
    
        $cliente = Cliente::with('persona')
                ->whereHas('persona', function($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%')
                          ->orWhere('apellido', 'like', '%' . $this->search . '%');
                })
                ->find($visita->id_cliente); // Aquí usamos find para un cliente específico


        $this->searchPersona = $cliente->persona->nombre; // Asigna el nombre
        $this->obtenerIdPersona = $visita->id_cliente;
        $this->selectedPersona = true;
    
        $this->visita->fill([
            'id_cliente' => $this->obtenerIdPersona, 
            'fecha' => $visita->fecha, 
            'hora' => $visita->hora, 
            'id_contacto' => $visita->id_contacto, 
            'ubicacion_map' =>  $visita->ubicacion_map, 
        ]);
    
        $this->openModalEdit = true;
    }
    


    public function update()
    {
        $id = $this->idVisita;

        $this->visita->fill([
            'id_persona' => $this->obtenerIdPersona,
        ]);
        
        $this->visita->validate();
        $visita = Visita::find($id);
        $visita = $visita->update($this->visita->only('id_cliente','fecha','hora','id_contacto','ubicacion_map'));

        $response = $visita ? true : false;
        $this->resetAttribute();
        $this->dispatch('notificar', message: $response);
    }

    // #[On('delete')]
    public function destroy($id)
    {

        $visita = Visita::find($id);
        $estado = $visita->estado;

        if($estado == 1)
        {
            $visita->estado = 0;
        }else{
            $visita->estado = 1;
        }
        $visita->save();
    }
}
