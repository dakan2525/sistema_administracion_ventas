@extends('template')

@section('title', 'roles')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

    @if (session('success'))
        <script>
            let message = "{{ session('success') }}"
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        </script>
    @endif


    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">roles</li>
        </ol>
        @can('crear-role')
            <div class="mb-4">
                <a href="{{ route('role.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
            </div>
        @endcan
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de roles
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Actualizado</th>
                            @can('editar-role', 'eliminar-role')
                                <th class="text-center">Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr class="">
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->updated_at }}</td>
                                <td>
                                    @can('editar-role')
                                        <a class="btn btn-primary fw-semibold"
                                            href="{{ route('role.edit', ['role' => $role]) }}">Editar</a>
                                    @endcan
                                    @can('eliminar-role')
                                        <button type="button" class="btn btn-danger fw-semibold" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $role->id }}">Eliminar</button>
                                    @endcan
                                </td>
                            </tr>
                            {{-- modal eliminar --}}
                            <div class="modal fade" id="confirmModal-{{ $role->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                Eliminar
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que desea eliminar este rol?
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1" action="{{ route('role.destroy', $role) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="reset" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
