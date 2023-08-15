@extends('BreadPermissions::layouts.app')

@section('content')
<div class="container">
    <div class="row g-5 g-xl-8">
        <div class="col-12">
            <div class="card crm-widget py-4 px-3">
                <div class="card-body">
                    <div class="d-flex gap-3 justify-content-end mb-4">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-1 fs-5">
                                <i class="fas fa-chart-pie"></i>
                                Crear Rol
                            </a>
                        </div>
                    </div>

                    @include('BreadPermissions::custom.messages')
    
                    <table class="table table-striped" id="table_roles">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Rol</th>
                                <th>Acceso Completo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if ($role->full_access == 'yes')
                                            <span class="badge bg-success">Si</span>
                                        @elseif ($role->full_access == 'no')
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info">
                                            {{-- <i class="fas fa-edit"></i> --}}
                                            Ver
                                        </a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
                                            {{-- <i class="fas fa-edit"></i> --}}
                                            Editar
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{-- <i class="fas fa-trash-alt"></i> --}}
                                                Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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