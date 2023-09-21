@extends('template')

@section('title', 'Crear roles')

@push('css')
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Crear roles</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- nombre de rol --}}
                    <div class="row mb-4 col-12 mt-4">
                        <label for="name" class="col-sm-2 col-form-label text-center">Nombre del rol: </label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}">
                        </div>
                        <div class="col-sm-6 ">
                            @error('name')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- pemisos --}}
                    <div class="row  mb-4 col-11 mx-auto ">
                        <label class="form-label mb-4" for="permisos">Permisos para rol: </label>
                        @foreach ($permisos as $permiso)
                            <div class="form-check col-3 mb-2 ">
                                <input class="form-check-input" type="checkbox" name="permission[]" id="{{ $permiso->id }}"
                                    value="{{ $permiso->id }}">
                                <label for="{{ $permiso->id }}" class="form-check-label">{{ $permiso->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('permission')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    @endsection

    @push('js')
    @endpush
