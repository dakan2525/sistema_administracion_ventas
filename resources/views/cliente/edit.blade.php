@extends('template')

@section('title', 'Editar cliente')

@push('css')
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('cliente.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Editar cliente</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('cliente.update', ['cliente' => $cliente]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row g-3">

                    {{-- tipo de persona --}}
                    <div class="col-md-6 mb-2">
                        <label for="tipo_persona" class="form-label">Tipo de cliente:
                            <span class="fw-semibold">{{ $cliente->persona->tipo_persona }}</span></label>
                    </div>

                    {{-- Razón social --}}
                    <div class="col-md-12 mb-2">
                        @if ($cliente->persona->tipo_persona == 'Natural')
                            <label id="razon_social" class="form-label" for="razon_social">Nombres y apellidos</label>
                        @else
                            <label id="razon_social" class="form-label" for="razon_social">Nombre de la empresa</label>
                        @endif


                        <input type="text" name="razon_social" id="razon_social" class="form-control"
                            value="{{ old('razon_social', $cliente->persona->razon_social) }}">
                        @error('razon_social')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Direccion --}}
                    <div class="col-md-12 mb-2">
                        <label for="direccion" class="form-label">Dirección: </label>
                        <input type="text" name="direccion" class="form-control"
                            value="{{ old('direccion', $cliente->persona->direccion) }}">
                        @error('direccion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Documento --}}
                    <div class="col-md-6 mb-2">
                        <label for="documento_id" class="form-label">Tipo de documento: </label>
                        <select class="form-select" name="documento_id" id="documento_id">
                            <option disabled selected value="">Seleccione una opción</option>
                            @foreach ($documentos as $documento)
                                <option value="{{ $documento->id }}"
                                    {{ old('documento_id', $cliente->persona->documento->id) == $documento->id ? 'selected' : '' }}>
                                    {{ $documento->tipo_documento }}</option>
                            @endforeach
                        </select>
                        @error('documento_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- numero documento --}}
                    <div class="col-md-6 mb-2">
                        <label for="numero_documento" class="form-label">Numero de documento: </label>
                        <input type="text" name="numero_documento" class="form-control"
                            value="{{ old('numero_documento', $cliente->persona->numero_documento) }}">
                        @error('numero_documento')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>


                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-secondary">Reiniciar</button>
                    </div>

                </div>
            </form>
        </div>

    @endsection


    @push('js')
    @endpush
