<!-- resources/views/user/dashboard.blade.php -->
@extends('layouts.app')

@section('header')
    <h2>Dashboard de Usuario</h2>
@endsection

@section('content') <!-- Cambia 'slot' por 'content' o un nombre que estés utilizando -->
    <div>
        <p style="color: white">Este es el contenido del dashboard del usuario.</p>
        <ul style="color: white">
            <li>Elemento 1</li>
            <li>Elemento 2</li>
            <li>Elemento 3</li>
        </ul>
    </div>
@endsection
