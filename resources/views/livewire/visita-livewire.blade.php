<div>
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
                        @if($visitas->count())
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead class="thead-dark table-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>CLIENTE</th>
                                        <th>FECHA</th>
                                        <th>HORA</th>
                                        <th>UBICACION</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitas as $visita)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ucwords(strtolower($visita->nombre))}} {{ ucwords(strtolower($visita->apellido))}}</td>
                                            <td>{{ucwords(strtolower($visita->fecha))}}</td>
                                            <td>{{ucwords(strtolower($visita->hora))}}</td>
                                            <td>{{ucwords(strtolower($visita->ubicacion_map))}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm" wire:click="edit({{ $visita->id }})"><i class="fas fa-pencil-alt"></i></button>
                                                    @if ($visita->estado == 1)
                                                        <button class="btn btn-danger btn-sm" wire:click="destroy({{ $visita->id }})"><i class="fas fa-trash"></i></button>
                                                    @else
                                                        <button class="btn btn-primary btn-sm" wire:click="destroy({{ $visita->id }})"><i class="fas fa-history"></i></button>
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
                            <h4 class="modal-title font-italic font-weight-bold">Registrar Visita</h4>
                            <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal" wire:click="closeModal">×</button>
                        </div>
            
                        <!-- Contenido del Modal -->
                        <div class="modal-body">
                            <form wire:submit="created">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" wire:model="obtenerIdPersona" required>
                                        <label for="">Buscar Cliente*:</label>
                                        <input type="text" class="form-control buscar" placeholder="Buscar..." aria-label="Buscador" wire:model.live="searchPersona" 
                                        @if($selectedPersona) disabled @endif>
                                    </div>
                                    <div class="col-md-12 rounded p-3 mt-2" id="contenedorBuscador">
                                        @if(isset($personas) && strlen($searchPersona) > 0)
                                        
                                            @if($personas->isNotEmpty())
                                                <table class="table table-bordered table-sm table-hover">
                                                    <thead class="bg-secondary">
                                                        <tr class="text-center">
                                                            <th>NOMBRE</th>
                                                            <th>APELLIDO</th>
                                                            <th>TELEFONO</th>
                                                            <th>ACCION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($personas as $persona)
                                                            <tr class="persona-row" wire:key="persona-{{$persona->id}}" data-id="{{$persona->id}}" @if($selectedPersona && $obtenerIdPersona != $persona->id) style="display: none;" @endif>
                                                                <td>{{ $persona->persona->nombre }}</td>
                                                                <td>{{ $persona->persona->apellido }}</td>
                                                                <td class="text-center">{{ $persona->persona->telefono }}</td>
                                                                <td class="text-center">
                                                                    <a wire:click="seleccionarPersona({{ $persona->id }})" class="btn @if($obtenerIdPersona == $persona->id) btn-danger @else btn-outline-success @endif btn-sm botones ">
                                                                        @if($obtenerIdPersona == $persona->id)
                                                                            Cancelar
                                                                        @else
                                                                            Seleccionar
                                                                        @endif
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p class="text-center">Ningun dato encontrado.</p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Contacto*:</label>
                                        <select class="form-control mt-2" wire:model="visita.id_contacto" required>
                                            <option value="0" selected>Seleccionar</option>
                                            @foreach ($contactos as $contacto)
                                                <option value="{{$contacto->id}}">{{$contacto->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label for="">Fecha*:</label>
                                        <input type="date" class="form-control" wire:model="visita.fecha" required>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label for="">Hora*:</label>
                                        <input type="time" class="form-control" wire:model="visita.hora" required>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <!-- Input para la ubicación -->
                                        <label for="ubicacion_map">Ubicación de la visita (Latitud, Longitud):</label>
                                        <input type="text" name="ubicacion_map" placeholder="Coordenadas o dirección" wire:model="visita.ubicacion_map" required>
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
         <div class="modal bd-example-modal-xs" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block" aria-modal="true" role="dialog">
             <div class="modal-dialog modal-xs">
                 <div class="modal-content">
 
                     <!-- Encabezado del Modal -->
                     <div class="modal-header bg-primary d-flex justify-content-between">
                         <h4 class="modal-title font-italic font-weight-bold">Editar Visita</h4>
                         <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal" wire:click="closeModal">×</button>
                     </div>
         
                     <!-- Contenido del Modal -->
                     <div class="modal-body">
                         <form wire:submit="update">
                             <div class="row">
                                 <div class="col-md-12">
                                     <input type="hidden" wire:model="obtenerIdPersona" required>
                                     <label for="">Buscar Cliente*:</label>
                                     <input type="text" class="form-control buscar" placeholder="Buscar..." aria-label="Buscador" wire:model.live="searchPersona" 
                                     @if($selectedPersona) disabled @endif>
                                 </div>
                                 <div class="col-md-12 rounded p-3 mt-2" id="contenedorBuscador">
                                     @if(isset($personas) && strlen($searchPersona) > 0)
                                     
                                         @if($personas->isNotEmpty())
                                             <table class="table table-bordered table-sm table-hover">
                                                 <thead class="bg-secondary">
                                                     <tr class="text-center">
                                                         <th>NOMBRE</th>
                                                         <th>APELLIDO</th>
                                                         <th>TELEFONO</th>
                                                         <th>ACCION</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                     @foreach($personas as $persona)
                                                         <tr class="persona-row" wire:key="persona-{{$persona->id}}" data-id="{{$persona->id}}" @if($selectedPersona && $obtenerIdPersona != $persona->id) style="display: none;" @endif>
                                                             <td>{{ $persona->persona->nombre }}</td>
                                                             <td>{{ $persona->persona->apellido }}</td>
                                                             <td class="text-center">{{ $persona->persona->telefono }}</td>
                                                             <td class="text-center">
                                                                 <a wire:click="seleccionarPersona({{ $persona->id }})" class="btn @if($obtenerIdPersona == $persona->id) btn-danger @else btn-outline-success @endif btn-sm botones ">
                                                                     @if($obtenerIdPersona == $persona->id)
                                                                         Cancelar
                                                                     @else
                                                                         Seleccionar
                                                                     @endif
                                                                 </a>
                                                             </td>
                                                         </tr>
                                                     @endforeach
                                                 </tbody>
                                             </table>
                                         @else
                                             <p class="text-center">Ningun dato encontrado.</p>
                                         @endif
                                     @endif
                                 </div>
                                 <div class="col-md-12">
                                     <label for="">Contacto*:</label>
                                     <select class="form-control mt-2" wire:model="visita.id_contacto" required>
                                         <option value="0" selected>Seleccionar</option>
                                         @foreach ($contactos as $contacto)
                                             <option value="{{$contacto->id}}">{{$contacto->nombre}}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                 <div class="col-md-6 mt-4">
                                     <label for="">Fecha*:</label>
                                     <input type="date" class="form-control" wire:model="visita.fecha" required>
                                 </div>
                                 <div class="col-md-6 mt-4">
                                    <label for="hora">Hora*:</label>
                                    <input type="time" class="form-control" wire:model="visita.hora" required>
                                </div>
                                 <div class="col-md-12 mt-4">
                                     <!-- Input para la ubicación -->
                                     <label for="ubicacion_map">Ubicación de la visita (Latitud, Longitud):</label>
                                     <input type="text" name="ubicacion_map" placeholder="Coordenadas o dirección" wire:model="visita.ubicacion_map" required>
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
</div>
