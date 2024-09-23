@extends('layouts.app')

@section('title', 'Visita')
@livewireStyles

@section('content_header')
    <h1 class="fw-bold font-italic">Visita</h1>
@stop

@section('content')
    @livewire('VisitaLivewire')
@stop

{{-- @section('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '¡Hola!',
                text: 'Este es un mensaje personalizado con SweetAlert2',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
@endsection --}}

@section('custom-scripts')
<script>
    notificacion();
</script>
@endsection
@livewireScripts
