<?php

namespace App\Livewire;

use App\Livewire\Form\PersonaForm;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonaLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchPersona;
    public $idPersona = "";

    public $openModalNew = false;
    public $openModalEdit = false;
    public PersonaForm $persona;

    public $foto;
    public $fotoEdit;


    public function resetAttribute()
    {
        $this->reset(['openModalNew', 'openModalEdit', 'search', 'idPersona', 'persona', 'searchPersona','foto']);
    }

    public function closeModal()
    {
        $this->resetAttribute();
        $this->resetValidation();
    }

    public function render()
    {

        $personas = Persona::where(function($query) {
                                $query->where('nombre', 'like', '%' . $this->search . '%')
                                        ->orWhere('apellido', 'like', '%' . $this->search . '%')
                                        ->orWhere('direccion', 'like', '%' . $this->search . '%')
                                        ->orWhere('telefono', 'like', '%' . $this->search . '%');
                                })
                                ->orderBy('id', 'desc')
                                ->paginate(5);

        return view('livewire.persona-livewire', compact('personas'));
    }

    public function fotoConvert($foto)
    {
        // Verificamos si se subió una foto
        // Obtén el nombre original
        
        $extension = $foto->getClientOriginalExtension();
    
        // Crea un nombre basado en la fecha y hora actual
        $newFileName = now()->format('Ymd_His') . '.' . $extension;
        
        // Almacena el archivo en la carpeta pública 'fotos'
        $path = $foto->storeAs('fotos', $newFileName, 'public');
        // Elimina el archivo temporal
        $foto->delete();

        return $path;
    }

    public function created()
    {
        $this->persona->validate();

        $path = $this->fotoConvert($this->foto);

        $persona =  Persona::create([
            'nombre' => $this->persona->nombre, 
            'apellido' => $this->persona->apellido, 
            'foto' => $path, 
            'direccion' => $this->persona->direccion, 
            'telefono' => $this->persona->telefono, 
        ]);

       $response = $persona ? true : false;
       $this->dispatch('notificar', message: $response);
       $this->resetAttribute();
    }

    public function edit($id)
    {
        $this->idPersona = $id;
        $persona = Persona::find($id);

        $this->persona->fill([
            'nombre' => $persona->nombre, 
            'apellido' => $persona->apellido, 
            'foto' => $persona->foto,
            'direccion' => $persona->direccion, 
            'telefono' => $persona->telefono, 
        ]);
        $this->fotoEdit = $persona->foto;
        $this->openModalEdit = true;
    }

    public function update()
    {
        $id = $this->idPersona;
        
        // $this->persona->validate();
        $persona = Persona::find($id);
        // if ($persona->foto) {
        //     Storage::disk('public')->delete($persona->foto);
        // }

        if ($this->foto) 
        {
            // if ($persona->foto) {
            //     Storage::disk('public')->delete($persona->foto);
            // }
            $path = $this->fotoConvert($this->foto);
            
            $this->persona->foto = $path;
        }

        $persona = $persona->update($this->persona->only('nombre','apellido','foto','direccion','telefono'));

        $response = $persona ? true : false;
        $this->resetAttribute();
        $this->dispatch('notificar', message: $response);
    }

    // #[On('delete')]
    public function destroy($id)
    {

        $persona = Persona::find($id);
        $estado = $persona->estado;

        if($estado == 1)
        {
            $persona->estado = 0;
        }else{
            $persona->estado = 1;
        }
        $persona->save();
    }
}
