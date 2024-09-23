<?php

namespace App\Livewire;

use App\Livewire\Form\ClienteForm;
use App\Models\Cargo;
use App\Models\Cliente;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClienteLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchPersona;
    public $selectedPersona = false;
    public $obtenerIdPersona = "";
    public $idCliente = "";

    public $openModalNew = false;
    public $openModalEdit = false;

    public ClienteForm $cliente;


    public function resetAttribute()
    {
        $this->reset(['openModalNew', 'openModalEdit', 'search','idCliente' ,'cliente', 'searchPersona','selectedPersona','obtenerIdPersona']);
    }

    public function closeModal()
    {
        $this->resetAttribute();
        $this->resetValidation();
    }

    public function render()
    {

        $clientes = Cliente::with(['persona','cargo'])
                    ->whereHas('persona', function($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        $cargos = Cargo::all();
        $personas = collect();

        if(!empty($this->searchPersona))
        {
            $personas = Persona::where('estado', 1)
                                ->where(function($query) {
                                    $query->where('nombre', 'like', '%' . $this->searchPersona . '%')
                                            ->orWhere('apellido', 'like', '%' . $this->searchPersona . '%')
                                            ->orWhere('telefono', 'like', '%' . $this->searchPersona . '%')
                                            ->orderBy('id','desc');
                                })
                                ->limit(5)
                                ->get();
        }
        return view('livewire.cliente-livewire', compact('clientes', 'personas','cargos'));
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
        $this->cliente->id_persona = $this->obtenerIdPersona;

        $this->cliente->validate();
        
        $cliente = Cliente::create([
            'id_persona' => $this->cliente->id_persona, 
            'id_cargo' => $this->cliente->id_cargo, 
        ]);

       $response = $cliente ? true : false;
       $this->dispatch('notificar', message: $response);
       $this->resetAttribute();
    }

    public function edit($id)
    {
        $this->idCliente = $id;
        $cliente = Cliente::find($id);
    
        // Cambia la consulta para obtener el resultado
        $persona = Persona::find($cliente->id_persona);
        // Verifica si se encontró la persona
        $this->searchPersona = $persona->nombre; // Asigna el nombre
        $this->obtenerIdPersona = $cliente->id_persona;
        $this->selectedPersona = true;
    
        $this->cliente->fill([
            'id_persona' => $this->obtenerIdPersona, 
            'id_cargo' => $cliente->id_cargo, 
        ]);
    
        $this->openModalEdit = true;
    }
    


    public function update()
    {
        $id = $this->idCliente;

        $this->cliente->fill([
            'id_persona' => $this->obtenerIdPersona,
        ]);
        
        $this->cliente->validate();
        $cliente = Cliente::find($id);
        $cliente = $cliente->update($this->cliente->only('id_persona','id_cargo'));

        $response = $cliente ? true : false;
        $this->resetAttribute();
        $this->dispatch('notificar', message: $response);
    }

    // #[On('delete')]
    public function destroy($id)
    {

        $cliente = Cliente::find($id);
        $estado = $cliente->estado;

        if($estado == 1)
        {
            $cliente->estado = 0;
        }else{
            $cliente->estado = 1;
        }
        $cliente->save();
    }
}
