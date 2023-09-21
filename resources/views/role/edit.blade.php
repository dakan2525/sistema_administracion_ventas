@extends('template')

@section('title', 'Editar role')

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
        <h1 class="mt-4 text-center">Editar roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Editar roles</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('role.update', ['role' => $role]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row g-3">

                    {{-- nombre de rol --}}
                    <div class="row mb-4 col-12">
                        <label for="name" class="col-sm-2 col-form-label">Nombre del rol: </label>
                        <div class="col-sm-4">
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $role->name) }}">
                        </div>
                        <div class="col-sm-6 ">
                            @error('name')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- pemisos --}}
                    <div class="row  mb-4 col-12 mx-auto ">
                        <label class="form-label mb-4" for="permisos">Permisos para rol: </label>
                        @foreach ($permisos as $permiso)
                            @if (in_array($permiso->id, $role->permissions->pluck('id')->toArray()))
                                <div class="form-check col-3 mb-2 ">
                                    <input checked class="form-check-input" type="checkbox" name="permission[]"
                                        id="{{ $permiso->id }}" value="{{ $permiso->id }}">
                                    <label for="{{ $permiso->id }}" class="form-check-label">{{ $permiso->name }}</label>
                                </div>
                            @else
                                <div class="form-check col-3 mb-2 ">
                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                        id="{{ $permiso->id }}" value="{{ $permiso->id }}">
                                    <label for="{{ $permiso->id }}" class="form-check-label">{{ $permiso->name }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @error('permission')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror

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
