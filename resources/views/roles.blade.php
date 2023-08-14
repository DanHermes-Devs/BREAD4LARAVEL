@extends('layouts.app')

@section('content')

<form action="/ruta-para-guardar-roles" method="post">
    @csrf

    <!-- Aquí iría el campo para el nombre del rol -->
    <input type="text" name="name" placeholder="Nombre del rol">

    @foreach($breads as $bread)
        <fieldset>
            <legend>{{ $bread->name }}</legend>
            @foreach($bread->permissions as $permission)
                <label>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    {{ ucfirst($permission->display_name) }} {{ $bread->display_name }}
                </label>
            @endforeach
        </fieldset>
    @endforeach

    <button type="submit">Enviar</button>
</form>


@endsection