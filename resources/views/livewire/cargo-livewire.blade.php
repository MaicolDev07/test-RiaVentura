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
                    @if($cargos->count())
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover ">
                            <thead class="thead-dark table-dark">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>SALARIO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cargos as $cargo)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ucwords(strtolower($cargo->nombre))}}</td>
                                        <td>{{ucwords(strtolower($cargo->salario))}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm" wire:click="edit({{ $cargo->id }})"><i class="fas fa-pencil-alt"></i></button>
                                                @if ($cargo->estado == 1)
                                                    <button class="btn btn-danger btn-sm" wire:click="destroy({{ $cargo->id }})"><i class="fas fa-trash"></i></button>
                                                @else
                                                    <button class="btn btn-primary btn-sm" wire:click="destroy({{ $cargo->id }})"><i class="fas fa-history"></i></button>
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
                                <h4 class="modal-title font-italic font-weight-bold">Registrar Cargo</h4>
                                <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal" wire:click="closeModal">×</button>
                            </div>
                
                            <!-- Contenido del Modal -->
                            <div class="modal-body">
                                <form wire:submit="created">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Nombre*:</label>
                                            <input class="form-control form-control-sm" type="text" wire:model="cargo.nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Salario*:</label>
                                            <input class="form-control form-control-sm" type="number" wire:model="cargo.salario" required>
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
                                                <input class="form-control form-control-sm" type="text" wire:model="cargo.nombre" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Salario*:</label>
                                                <input class="form-control form-control-sm" type="number" wire:model="cargo.salario" required>
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
        
                {{-- *** FIN MODAL AGREGAR PERSONA --}}
                    </div>
                </div>
            </div>
        {{-- **** FIN CONTENEDOR **** --}}
        </div>
        
        
</div>
