@extends('BreadPermissions::layouts.app')

@section('content')
<div class="container">
    <div class="row g-5 g-xl-8">
        <div class="col-12">
            <div class="card crm-widget py-4 px-3">
                <div class="card-body">
                    <div class="d-flex gap-3 justify-content-end mb-4">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-info d-flex align-items-center justify-content-center gap-1 fs-5">
                                <i class="fas fa-chart-pie"></i>
                                Regresar
                            </a>
                        </div>
                    </div>

                    @include('BreadPermissions::custom.messages')

                    
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nombre del Rol</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="full_access" class="form-label">Acceso Completo</label>
                            <select name="full_access" id="full_access" class="form-select">
                                <option value="no" @if($role->full_access == 'no') selected @endif>Seleccione una opción</option>
                                <option value="no" @if($role->full_access == 'no') selected @endif>No</option>
                                <option value="yes" @if($role->full_access == 'yes') selected @endif>Si</option>
                            </select>
                        </div>
                    
                        @foreach($breads as $bread)
                            <fieldset>
                                <legend>{{ $bread->name }}</legend>
                                <ul class="list-unstyled">
                                    @foreach($bread->permissions as $permission)
                                        <li class="mb-2">
                                            <div class="form-check ms-3">
                                                <input class="form-check-input no-border" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                                    @if(in_array($permission->id, $permission_role)) checked @endif
                                                >
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ ucfirst($permission->display_name) }} {{ $bread->display_name }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </fieldset>
                        @endforeach
                    
                        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_roles').DataTable();
    });
</script>
@endsection