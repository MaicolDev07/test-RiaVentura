<?php

namespace App\Livewire;

use App\Livewire\Form\VendedorForm;
use App\Models\Cargo;
use App\Models\Persona;
use App\Models\Vendedor;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class VendedorLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchPersona;
    public $selectedPersona = false;
    public $obtenerIdPersona = "";
    public $idVendedor = "";

    public $openModalNew = false;
    public $openModalEdit = false;

    public VendedorForm $vendedor;


    public function resetAttribute()
    {
        $this->reset(['openModalNew', 'openModalEdit', 'search','idVendedor' ,'vendedor', 'searchPersona','selectedPersona','obtenerIdPersona']);
    }

    public function closeModal()
    {
        $this->resetAttribute();
        $this->resetValidation();
    }

    public function render()
    {

        $vendedores = Vendedor::with(['persona','cargo']) // Cargar la relación persona
                    ->whereHas('persona', function($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        $cargos = Cargo::all();
        // $persona = Persona::all();
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
        return view('livewire.vendedor-livewire', compact('vendedores', 'cargos', 'personas'));
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
        $this->vendedor->id_persona = $this->obtenerIdPersona;

        $this->vendedor->validate();
        
        $vendedor = Vendedor::create([
            'id_persona' => $this->vendedor->id_persona, 
            'id_cargo' => $this->vendedor->id_cargo, 
        ]);

       $response = $vendedor ? true : false;
       $this->dispatch('notificar', message: $response);
       $this->resetAttribute();
    }

    public function edit($id)
    {
        $this->idVendedor = $id;
        $vendedor = Vendedor::find($id);
    
        // Cambia la consulta para obtener el resultado
        $persona = Persona::find($vendedor->id_persona);
        // Verifica si se encontró la persona
        $this->searchPersona = $persona->nombre; // Asigna el nombre
        $this->obtenerIdPersona = $vendedor->id_persona;
        $this->selectedPersona = true;
    
        $this->vendedor->fill([
            'id_persona' => $this->obtenerIdPersona, 
            'id_cargo' => $vendedor->id_cargo, 
        ]);
    
        $this->openModalEdit = true;
    }
    


    public function update()
    {
        $id = $this->idVendedor;

        $this->vendedor->fill([
            'id_persona' => $this->obtenerIdPersona,
        ]);
        
        $this->vendedor->validate();
        $vendedor = Vendedor::find($id);
        $vendedor = $vendedor->update($this->vendedor->only('id_persona','id_cargo'));

        $response = $vendedor ? true : false;
        $this->resetAttribute();
        $this->dispatch('notificar', message: $response);
    }

    // #[On('delete')]
    public function destroy($id)
    {

        $vendedor = Vendedor::find($id);
        $estado = $vendedor->estado;

        if($estado == 1)
        {
            $vendedor->estado = 0;
        }else{
            $vendedor->estado = 1;
        }
        $vendedor->save();
    }
}
