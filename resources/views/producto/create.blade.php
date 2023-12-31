@extends('template')

@section('title', 'Crear productos')

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
        <h1 class="mt-4 text-center">Crear productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('producto.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Crear producto</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Codigo --}}
                    <div class="col-md-6 mb-4">
                        <label for="codigo" class="form-label">Código:</label>
                        <input type="text" name="codigo" id="codigo" class="form-control"
                            value="{{ old('codigo') }}">
                        @error('codigo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div class="col-md-6 mb-4">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Descripcion --}}
                    <div class="col-md-12 mb-4">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea cols="30" rows="3" name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Fecha vencimiento --}}
                    <div class="col-md-6 mb-4">
                        <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
                            value="{{ old('fecha_vencimiento') }}">
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
                                <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre }}</option>
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
                                <option value="{{ $presentacion->id }}"
                                    {{ old('presentacion_id') == $presentacion->id ? 'selected' : '' }}>
                                    {{ $presentacion->nombre }}</option>
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
                                <option value="{{ $categoria->id }}"
                                    {{ in_array($categoria->id, old('categorias', [])) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="col-12 text-center mb-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush















<div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header">
        <h3 class="text-center font-weight-light my-4">Acceso al sistema</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <form action="/login" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" id="inputEmail" name="email" type="email"
                    placeholder="name@example.com" value="{{ old('email') }}" />
                <label for="inputEmail">Correo eléctronico</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputPassword" name="password" type="password"
                    placeholder="Password" value="{{ old('password') }}" />
                <label for="inputPassword">Contraseña</label>
            </div>
            {{-- <div class="form-check mb-3">
                <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                    value="" />
                <label class="form-check-label" for="inputRememberPassword">Remember
                    Password</label>
            </div> --}}
            <div class="text-center mt-4 mb-0">
                {{-- <a class="small" href="password.html">Forgot Password?</a> --}}
                <button type="submit" class="btn btn-primary">Iniciar sesion</button>
            </div>
        </form>
    </div>
    {{-- <div class="card-footer text-center py-3">
        <div class="small"><a href="register.html">¿Necesita una cuenta? ¡Registrarse!</a>
        </div>
    </div> --}}
</div>
