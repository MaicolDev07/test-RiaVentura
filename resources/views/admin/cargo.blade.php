@extends('layouts.app')

@section('title', 'Cargo')
@livewireStyles

@section('content_header')
    <h1 class="fw-bold font-italic">Cargo</h1>
@stop

@section('content')
    @livewire('CargoLivewire')
@stop

@livewireScripts
