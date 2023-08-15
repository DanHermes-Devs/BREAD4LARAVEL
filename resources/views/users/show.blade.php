@extends('BreadPermissions::layouts.app')

@section('content')
<div class="container">
    <div class="row g-5 g-xl-8">
        <div class="col-12">
            <div class="card crm-widget py-4 px-3">
                <div class="card-body">
                    <div class="d-flex gap-3 justify-content-end mb-4">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-info d-flex align-items-center justify-content-center gap-1 fs-5">
                                <i class="fas fa-chart-pie"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nombre del Usuario</label>
                            <input type="text" disabled name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email del Usuario</label>
                            <input type="text" disabled name="name" class="form-control" value="{{ $user->email }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select disabled name="role_id" class="form-select">
                                <option value="">-- Seleccione una opción --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection