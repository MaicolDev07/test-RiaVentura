@extends('layouts.app')

@section('title', 'Persona')
@livewireStyles

@section('content_header')
    <h1 class="fw-bold font-italic">Persona</h1>
@stop

@section('content')
    @livewire('PersonaLivewire')
@stop

@livewireScripts
