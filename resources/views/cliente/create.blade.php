@extends('template')

@section('title', 'Crear cliente')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }

        #box-razon-social {
            display: none;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Cliente</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('cliente.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Crear cliente</li>
        </ol>

        <div class="container w-100 border border-3 border-darck rounded p-4 mt-3">
            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- tipo de persona --}}
                    <div class="col-md-6 mb-2">
                        <label for="tipo_persona" class="form-label">Tipo de cliente: </label>
                        <select class="form-select" name="tipo_persona" id="tipo_persona">
                            <option disabled selected value="">Seleccione una opción</option>
                            <option value="Natural" {{ old('tipo_persona') == 'Natural' ? 'selected' : '' }}>Persona
                                natural</option>
                            <option value="Jurídica" {{ old('tipo_persona') == 'Jurídica' ? 'selected' : '' }}>Persona
                                jurídica</option>

                        </select>
                        @error('tipo_persona')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Razón social --}}
                    <div class="col-md-12 mb-2" id="box-razon-social">
                        <label id="label-natural" class="form-label" for="razon_social">Nombres y apellidos</label>
                        <label id="label-juridica" class="form-label" for="razon_social">Nombre de la empresa</label>

                        <input type="text" name="razon_social" id="razon_social" class="form-control"
                            value="{{ old('razon_social') }}">
                        @error('razon_social')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    {{-- Direccion --}}
                    <div class="col-md-12 mb-2">
                        <label for="direccion" class="form-label">Dirección: </label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
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
                                    {{ old('documento_id') == $documento->id ? 'selected' : '' }}>
                                    {{ $documento->tipo_documento }}</option>
                            @endforeach
                        </select>
                        @error('documento_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>


                    <div class="col-md-6 mb-2">
                        <label for="numero_documento" class="form-label">Numero de documento: </label>
                        <input type="text" name="numero_documento" class="form-control"
                            value="{{ old('numero_documento') }}">
                        @error('numero_documento')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>


                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    @endsection

    @push('js')
        <script>
            $(document).ready(function() {
                $('#tipo_persona').on('change', function() {
                    let selectValue = $(this).val();

                    if (selectValue == 'Natural') {
                        $('#label-natural').show();
                        $('#label-juridica').hide();
                    } else {
                        $('#label-natural').hide();
                        $('#label-juridica').show();
                    }

                    $('#box-razon-social').show();

                });
            });
        </script>
    @endpush
