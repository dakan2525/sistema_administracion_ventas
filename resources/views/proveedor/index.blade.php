@extends('template')

@section('title', 'Proveedores')


@push('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

    {{-- este if se encarga de validar si en la session se creo success y si es asi manda la alerta de Operación exitosa --}}
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
        <h1 class="mt-4 text-center">Proveedores</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Proveedores</li>
        </ol>

        @can('crear-proveedor')
            <div class="mb-4">
                <a href="{{ route('proveedor.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
            </div>
        @endcan

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Proveedores
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Direccion</th>
                            <th class="text-center">Tipo de documento</th>
                            <th class="text-center">Numero de documento</th>
                            <th class="text-center">Tipo de proveedor</th>
                            <th class="text-center">Estado</th>
                            @can('editar-proveedor', 'eliminar-proveedor')
                                <th class="text-center">Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $proveedor)
                            <tr>
                                <td>
                                    {{ $proveedor->persona->razon_social }}
                                </td>
                                <td>
                                    {{ $proveedor->persona->direccion }}
                                </td>
                                <td>
                                    {{ $proveedor->persona->documento->tipo_documento }}
                                </td>
                                <td>
                                    {{ $proveedor->persona->numero_documento }}
                                </td>
                                <td>
                                    {{ $proveedor->persona->tipo_persona }}
                                </td>
                                <td class="fw-semibold">
                                    @if ($proveedor->persona->estado == 1)
                                        <span>Activo</span>
                                    @else
                                        <span>Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    @can('editar-proveedor')
                                        <a class="btn btn-primary" href="{{ route('proveedor.edit', $proveedor) }}">
                                            Editar</a>
                                    @endcan
                                    @can('eliminar-proveedor')
                                        @if ($proveedor->persona->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $proveedor->id }}">Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $proveedor->id }}">Restaurar</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $proveedor->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                {{ $proveedor->persona->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $proveedor->persona->estado == 1 ? '¿Seguro que desea eliminar este proveedor?' : '¿Seguro que desea restaurar este proveedor?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1" action="{{ route('proveedor.destroy', $proveedor->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="reset" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>

                                                @if ($proveedor->persona->estado == 1)
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                @else
                                                    <button type="submit" class="btn btn-success">Restaurar</button>
                                                @endif
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
