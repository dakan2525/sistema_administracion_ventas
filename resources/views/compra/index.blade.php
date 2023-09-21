@extends('template')

@section('title', 'Compras')


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
        <h1 class="mt-4 text-center">Compras</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Compras</li>
        </ol>

        @can('crear-compra')
            <div class="mb-4">
                <a href="{{ route('compra.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
            </div>
        @endcan

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de compras
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-center">Combrobante</th>
                            <th class="text-center">Proveedor</th>
                            <th class="text-center">Fecha y hora</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>
                                    <p class="fw-semibold">
                                        {{ $compra->comprobante->tipo_comprobante . ' #' . $compra->numero_comprobante }}
                                    </p>
                                </td>
                                <td>
                                    <p class="fw-semibold">
                                        {{ $compra->proveedore->persona->razon_social . ' - ' . $compra->proveedore->persona->tipo_persona }}
                                    </p>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($compra->fecha_hora)->format('d-m-Y  H:i') }}
                                </td>
                                <td>
                                    {{ $compra->total }}
                                </td>

                                <td class="fw-semibold">
                                    @if ($compra->estado == 1)
                                        <span>Activo</span>
                                    @else
                                        <span>Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('compra.show', ['compra' => $compra]) }}">
                                        Ver</a>
                                    @can('eliminar-compra')
                                        @if ($compra->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $compra->id }}">Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $compra->id }}">Restaurar</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $compra->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                {{ $compra->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $compra->estado == 1 ? '¿Seguro que desea eliminar esta compra?' : '¿Seguro que desea restaurar esta compra?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1"
                                                action="{{ route('compra.destroy', ['compra' => $compra]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="reset" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>

                                                @if ($compra->estado == 1)
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
