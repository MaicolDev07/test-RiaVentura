@extends('layouts.app')

@section('title', 'Cliente')
@livewireStyles

@section('content_header')
    <h1 class="fw-bold font-italic">Cliente</h1>
@stop

@section('content')
    @livewire('ClienteLivewire')
@stop

@livewireScripts
