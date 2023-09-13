@extends('template')

@section('title', 'Productos')

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
        <h1 class="mt-4 text-center">Productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>
        <div class="mb-4">
            <a href="{{ route('producto.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de productos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Presentacion</th>
                            <th>Categorías</th>
                            <th>Marca</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="">
                                <td>{{ $producto->codigo }}</td>

                                <td class="fw-semibold">{{ $producto->nombre }}</td>

                                <td>{{ $producto->presentacione->caracteristica->nombre }}</td>

                                <td>
                                    @foreach ($producto->categorias as $category)
                                        <div class="container">
                                            <div class="row">
                                                <span
                                                    class="m-1 rounded-pill fw-semibold">{{ $category->caracteristica->nombre }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>

                                <td>{{ $producto->marca->caracteristica->nombre }}</td>

                                <td class="fw-semibold">
                                    @if ($producto->estado == 1)
                                        <span>Activo</span>
                                    @else
                                        <span>Eliminado</span>
                                    @endif
                                </td>

                                <td>
                                    <a class="btn btn-primary fw-semibold"
                                        href="{{ route('producto.edit', ['producto' => $producto]) }}">Editar</a>
                                    <a href="#" class="btn btn-success fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#verModal-{{ $producto->id }}">Ver</a>
                                    @if ($producto->estado == 1)
                                        <button type="button" class="btn btn-danger fw-semibold" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $producto->id }}">Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-success fw-semibold" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $producto->id }}">Restaurar</button>
                                    @endif
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="verModal-{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Descripción:
                                                    </span>{{ $producto->descripcion }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Fecha de
                                                        vencimiento: </span> {{ $producto->fecha_vencimiento }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Stock: </span>
                                                    {{ $producto->stock }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="fw-bolder mb-2" for="">Imagen: </label>
                                                <div>
                                                    @if ($producto->img_path != null)
                                                        <img src="{{ Storage::url('productos/' . $producto->img_path) }}"
                                                            alt="{{ $producto->nombre }}" class="img-fluid ">
                                                    @else
                                                        <img src="" alt="{{ $producto->nombre }}">
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="confirmModal-{{ $producto->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="confirmModalLabel">
                                                {{ $producto->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $producto->estado == 1 ? '¿Seguro que desea eliminar este producto?' : '¿Seguro que desea restaurar este producto?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <form class="m-1" action="{{ route('producto.destroy', $producto) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="reset" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancelar</button>

                                                @if ($producto->estado == 1)
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
