@extends('template')

@section('title', 'Categorías')


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
        <h1 class="mt-4 text-center">Marcas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Marcas</li>
        </ol>

        <div class="mb-4">
            <a href="{{ route('marca.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de marcasmarca
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($marcas as $marca)
                            <tr>
                                <td>{{ $marca->caracteristica->nombre }}</td>
                                <td>{{ $marca->caracteristica->descripcion }}</td>
                                <td>
                                    @if ($marca->caracteristica->estado > 0)
                                        <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                                    @else
                                        <span class="fw-bolder rounded bg-danger text-white p-1">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('marca.edit', $marca) }}">
                                        Editar</a>
                                    @if ($marca->caracteristica->estado == 1)
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $marca->id }}">Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $marca->id }}">Restaurar</button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $marca->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                {{ $marca->caracteristica->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $marca->caracteristica->estado == 1 ? '¿Seguro que desea eliminar esta marca?' : '¿Seguro que desea restaurar esta marca?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1" action="{{ route('marca.destroy', $marca->id) }}"
                                                method="POST">
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
                        @empty
                            <tr>
                                <h3 class="text-danger">No existen marcas</h3>
                            </tr>
                        @endforelse
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