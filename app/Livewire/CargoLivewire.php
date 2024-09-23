<?php

namespace App\Livewire;

use App\Livewire\Form\CargoForm;
use App\Models\Cargo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CargoLivewire extends Component
{
        use WithPagination;
        use WithFileUploads;
    
        protected $paginationTheme = 'bootstrap';
        public $search;
        public $searchCargo;
        public $idCargo = "";
    
        public $openModalNew = false;
        public $openModalEdit = false;
        public CargoForm $cargo;
    
    
    
        public function resetAttribute()
        {
            $this->reset(['openModalNew', 'openModalEdit', 'search','idCargo' ,'cargo', 'searchCargo']);
        }
    
        public function closeModal()
        {
            $this->resetAttribute();
            $this->resetValidation();
        }
    
        public function render()
        {
    
            $cargos = Cargo::where(function($query) {
                                    $query->where('nombre', 'like', '%' . $this->search . '%')
                                            ->orWhere('salario', 'like', '%' . $this->search . '%');
                                    })
                                    ->orderBy('id', 'desc')
                                    ->paginate(5);
    
            return view('livewire.cargo-livewire', compact('cargos'));
        }
    
        public function created()
        {
            $this->cargo->validate();
    
    
            $cargo =  Cargo::create([
                'nombre' => $this->cargo->nombre, 
                'salario' => $this->cargo->salario, 
            ]);
    
           $response = $cargo ? true : false;
           $this->dispatch('notificar', message: $response);
           $this->resetAttribute();
        }
    
        public function edit($id)
        {
            $this->idCargo = $id;
            $cargo = Cargo::find($id);
    
            $this->cargo->fill([
                'nombre' => $cargo->nombre, 
                'salario' => $cargo->salario, 
            ]);
            $this->openModalEdit = true;
        }
    
        public function update()
        {
            $id = $this->idCargo;
            
            // $this->persona->validate();
            $cargo = Cargo::find($id);

            $cargo = $cargo->update($this->cargo->only('nombre','salario'));
    
            $response = $cargo ? true : false;
            $this->resetAttribute();
            $this->dispatch('notificar', message: $response);
        }
    
        // #[On('delete')]
        public function destroy($id)
        {
    
            $cargo = Cargo::find($id);
            $estado = $cargo->estado;
    
            if($estado == 1)
            {
                $cargo->estado = 0;
            }else{
                $cargo->estado = 1;
            }
            $cargo->save();
        }
}
