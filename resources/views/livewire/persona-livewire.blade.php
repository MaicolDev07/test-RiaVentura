<div>
    <div>
        {{-- **** CONTENEDOR **** --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-6">
                                <button class="btn btn-success btn-md" wire:click="$toggle('openModalNew')"><i class="fas fa-plus-square"></i></button>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Buscar..." aria-label="buscar" aria-describedby="basic-addon1" wire:model.live="search">
                                </div>
                            </div>
                        </div>
        
                    </div>
                    @if($personas->count())
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover ">
                            <thead class="thead-dark table-dark">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>DIRECCION</th>
                                    <th>TELEFONO</th>
                                    <th>FOTO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personas as $persona)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ucwords(strtolower($persona->nombre))}}</td>
                                        <td>{{ucwords(strtolower($persona->apellido))}}</td>
                                        <td>{{ucwords(strtolower($persona->direccion))}}</td>
                                        <td>{{ucwords(strtolower($persona->telefono))}}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $persona->foto) }}" alt="Foto de {{ $persona->nombre }}" style="max-width: 100px; max-height: 40px; border-radius: 5px;">
                                        </td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm" wire:click="edit({{ $persona->id }})"><i class="fas fa-pencil-alt"></i></button>
                                                @if ($persona->estado == 1)
                                                    <button class="btn btn-danger btn-sm" wire:click="destroy({{ $persona->id }})"><i class="fas fa-trash"></i></button>
                                                @else
                                                    <button class="btn btn-primary btn-sm" wire:click="destroy({{ $persona->id }})"><i class="fas fa-history"></i></button>
                                                @endif
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                    @else
                        <div class="card-body">
                            <strong class="text-center">No hay registros</strong>
                        </div>
                    @endif
                </div>
        
            {{-- * MODAL --}}
            @if ($openModalNew)
                <!-- Modal -->
                <div class="modal bd-example-modal-xs" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
        
                            <!-- Encabezado del Modal -->
                            <div class="modal-header bg-primary d-flex justify-content-between">
                                <h4 class="modal-title font-italic font-weight-bold">Registrar Persona</h4>
                                <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal" wire:click="closeModal">×</button>
                            </div>
                
                            <!-- Contenido del Modal -->
                            <div class="modal-body">
                                <form wire:submit="created">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Nombre*:</label>
                                            <input class="form-control form-control-sm" type="text" wire:model="persona.nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Apellido*:</label>
                                            <input class="form-control form-control-sm" type="text" wire:model="persona.apellido" required>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="">Dirección*:</label>
                                            <input class="form-control form-control-sm" type="text" wire:model="persona.direccion" min="0" required>
                                        </div>
                                       
                                        <div class="col-md-6 mt-2">
                                            <label for="">Teléfono*:</label>
                                            <input class="form-control form-control-sm" type="number" wire:model="persona.telefono" min="6" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label for="">Foto:</label>
                                            <input class="form-control form-control-sm" type="file" wire:model="foto">
                                        </div>

                                    
                                        <div class="col-md-12 mt-4">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                          
                                    <div class="row d-flex justify-content-end mt-4">
                                        <x-button class="btn-success btn-sm">Guardar</x-button>
                                    </div>
                                </form>
                            </div>
                             
                        </div>
                    </div>
                </div>
            @endif
        
        
                {{-- * MODAL --}}
            @if ($openModalEdit)
            <!-- Modal -->
            <div class="modal bd-example-modal-lg" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
        
                        <!-- Encabezado del Modal -->
                        <div class="modal-header bg-primary d-flex justify-content-between">
                            <h4 class="modal-title font-italic font-weight-bold">EDITAR PERSONA</h4>
                            <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal" wire:click="closeModal">×</button>
                        </div>
            
                        <!-- Contenido del Modal -->
                                   <!-- Contenido del Modal -->
                                   <div class="modal-body">
                                    <form wire:submit="update">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Nombre*:</label>
                                                <input class="form-control form-control-sm" type="text" wire:model="persona.nombre" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Apellido*:</label>
                                                <input class="form-control form-control-sm" type="text" wire:model="persona.apellido" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label for="">Dirección*:</label>
                                                <input class="form-control form-control-sm" type="text" wire:model="persona.direccion" min="0" required>
                                            </div>
                                           
                                            <div class="col-md-6 mt-2">
                                                <label for="">Teléfono*:</label>
                                                <input class="form-control form-control-sm" type="number" wire:model="persona.telefono" min="6" required>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <label for="">Foto:</label>
                                                <input class="form-control form-control-sm" type="file" wire:model="foto">
                                            </div>
                                            <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                                <label>Vista Previa:</label><br>
                                                <img id="imagePreview" alt="Vista Previa" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            </div>
    
                                            @if($fotoEdit)
                                            <label class="text-center fw-bold">Imagen Existente:</label><br>

                                                <div class="mt-2 d-flex justify-content-center">
                                                    <img src="{{ asset('storage/' . $fotoEdit) }}" alt="Imagen Existente" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                </div>
                                            @endif
    
                                            <div class="col-md-12 mt-4">
                                                @if ($errors->any())
                                                <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                              
                                        <div class="row d-flex justify-content-end mt-4">
                                            <x-button class="btn-success btn-sm">Guardar</x-button>
                                        </div>
                                    </form>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                @endif
        
                {{-- *** FIN MODAL AGREGAR PERSONA --}}
                    </div>
                </div>
            </div>
        {{-- **** FIN CONTENEDOR **** --}}
        </div>
        
        
</div>
