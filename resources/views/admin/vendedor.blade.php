@extends('layouts.app')

@section('title', 'Vendedor')
@livewireStyles

@section('content_header')
    <h1 class="fw-bold font-italic">Vendedor</h1>
@stop

@section('content')
    @livewire('VendedorLivewire')
@stop

@livewireScripts
