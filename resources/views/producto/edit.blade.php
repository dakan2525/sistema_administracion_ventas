@extends('template')

@section('title', 'Editar producto')

@push('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #descripcion {
            resize: none
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar producto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('producto.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Editar producto</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('producto.update', ['producto' => $producto]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row g-3">

                    {{-- Codigo --}}
                    <div class="col-md-6 mb-4">
                        <label for="codigo" class="form-label">Código:</label>
                        <input type="text" name="codigo" id="codigo" class="form-control"
                            value="{{ old('codigo', $producto->codigo) }}">
                        @error('codigo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div class="col-md-6 mb-4">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $producto->nombre) }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Descripcion --}}
                    <div class="col-md-12 mb-4">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea cols="30" rows="3" name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Fecha vencimiento --}}
                    <div class="col-md-6 mb-4">
                        <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
                            value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento) }}">
                        @error('fecha_vencimiento')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Imagen --}}
                    <div class="col-md-6 mb-4">
                        <label for="img_path" class="form-label">Imagen:</label>
                        <input type="file" name="img_path" id="img_path" class="form-control"
                            value="{{ old('img_path') }}" accept="Image/*">
                        @error('img_path')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Marcas --}}
                    <div class="col-md-6 mb-4">
                        <label for="marca_id" class="form-label">Marca:</label>
                        <select data-size="3" title="Seleccione una marca" data-live-search="true" name="marca_id"
                            id="marca_id" class="form-control selectpicker show-tick">
                            @foreach ($marcas as $marca)
                                @if ($producto->marca_id == $marca->id)
                                    <option selected value="{{ $marca->id }}"
                                        {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                        {{ $marca->nombre }}</option>
                                @else
                                    <option value="{{ $marca->id }}"
                                        {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                        {{ $marca->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('marca_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Presentaciones --}}
                    <div class="col-md-6 mb-4">
                        <label for="presentacion_id" class="form-label">Presentaciones:</label>
                        <select data-size="3" title="Selceccione una presentación" show-tick data-live-search="true"
                            name="presentacion_id" id="presentacion_id" class="form-control selectpicker show-tick">
                            @foreach ($presentaciones as $presentacion)
                                @if ($producto->presentacione_id == $presentacion->id)
                                    <option selected value="{{ $presentacion->id }}"
                                        {{ old('presentacion_id') == $presentacion->id ? 'selected' : '' }}>
                                        {{ $presentacion->nombre }}</option>
                                @else
                                    <option value="{{ $presentacion->id }}"
                                        {{ old('presentacion_id') == $presentacion->id ? 'selected' : '' }}>
                                        {{ $presentacion->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('presentacion_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Categorias --}}
                    <div class="col-md-6 mb-4">
                        <label for="categorias" class="form-label">Categorías:</label>
                        <select multiple data-size="3" title="Selceccione una categoría" show-tick data-live-search="true"
                            name="categorias[]" id="categorias" class="form-control selectpicker show-tick">
                            @foreach ($categorias as $categoria)
                                @if (in_array($categoria->id, $producto->categorias->pluck('id')->toArray()))
                                    <option selected value="{{ $categoria->id }}"
                                        {{ in_array($categoria->id, old('categorias', [])) ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}</option>
                                @else
                                    <option value="{{ $categoria->id }}"
                                        {{ in_array($categoria->id, old('categorias', [])) ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="col-12 text-center mb-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-secondary">Reiniciar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
