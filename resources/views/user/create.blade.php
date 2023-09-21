@extends('template')

@section('title', 'Crear usuarios')

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
        <h1 class="mt-4 text-center">Crear usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Crear usuarios</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="row g-3 col-12 text-start">
                    {{-- nombre --}}
                    <div class="row mb-4 col-12 mt-4">
                        <label for="name" class="col-sm-3 col-form-label text-end px-4">Nombre: </label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Escriba un solo nombre" name="name" id="name"
                                class="form-control" value="{{ old('name') }}">

                        </div>
                        <div class="col-sm-3 ">
                            @error('name')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-4 col-12 ">
                        <label for="email" class="col-sm-3 col-form-label text-end px-4">Correo eléctronico: </label>
                        <div class="col-sm-6">
                            <input type="email" name="email" placeholder="Dirección de correo eléctronico"
                                id="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="col-sm-3 ">
                            @error('email')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- password --}}
                    <div class="row mb-4 col-12">
                        <label for="password" class="col-sm-3 col-form-label text-end px-4">Contraseña: </label>
                        <div class="col-sm-6">
                            <input type="password" name="password" placeholder="Debe incluir números" id="password"
                                class="form-control">
                        </div>
                        <div class="col-sm-3 ">
                            @error('password')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                    </div>

                    {{-- password - confirmacion --}}
                    <div class="row mb-4 col-12">
                        <label for="password_confirm" class="col-sm-3 col-form-label text-end px-4">Confirmar contraseña:
                        </label>
                        <div class="col-sm-6">
                            <input type="password" placeholder="Vuelva a escribir su contraseña" name="password_confirm"
                                id="password_confirm" class="form-control">
                        </div>
                        <div class="col-sm-3 ">
                            @error('password_confirm')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- roles --}}
                    <div class="row mb-4 col-12">
                        <label for="role" class="col-sm-3 col-form-label text-end px-4">Seleccione un rol: </label>
                        <div class="col-sm-6">
                            <select name="role" id="role" class="form-select">
                                <option selected disabled value="">Seleccione rol: </option>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}" @selected(old('role') == $item->name)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 ">
                            @error('role')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
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
