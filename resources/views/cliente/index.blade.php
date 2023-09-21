@extends('template')

@section('title', 'Clientes')


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
        <h1 class="mt-4 text-center">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>

        @can('crear-cliente')
            <div class="mb-4">
                <a href="{{ route('cliente.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
            </div>
        @endcan

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla clientes
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Direccion</th>
                            <th class="text-center">Tipo de documento</th>
                            <th class="text-center">Numero de documento</th>
                            <th class="text-center">Tipo de cliente</th>
                            <th class="text-center">Estado</th>
                            @can('editar-cliente', 'eliminar-cliente')
                                <th class="text-center">Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>
                                    {{ $cliente->persona->razon_social }}
                                </td>
                                <td>
                                    {{ $cliente->persona->direccion }}
                                </td>
                                <td>
                                    {{ $cliente->persona->documento->tipo_documento }}
                                </td>
                                <td>
                                    {{ $cliente->persona->numero_documento }}
                                </td>
                                <td>
                                    {{ $cliente->persona->tipo_persona }}
                                </td>
                                <td class="fw-semibold">
                                    @if ($cliente->persona->estado == 1)
                                        <span>Activo</span>
                                    @else
                                        <span>Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    @can('editar-cliente')
                                        <a class="btn btn-primary" href="{{ route('cliente.edit', $cliente) }}">
                                            Editar</a>
                                    @endcan
                                    @can('eliminar-cliente')
                                        @if ($cliente->persona->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $cliente->id }}">Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $cliente->id }}">Restaurar</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $cliente->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                {{ $cliente->persona->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $cliente->persona->estado == 1 ? '¿Seguro que desea eliminar este cliente?' : '¿Seguro que desea restaurar este cliente?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1" action="{{ route('cliente.destroy', $cliente->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="reset" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>

                                                @if ($cliente->persona->estado == 1)
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
