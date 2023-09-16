@extends('template')

@section('title', 'Compras')

@push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Detalle de compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('compra.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Detalle de Compra</li>
        </ol>
    </div>

    {{-- Tipo de comprobante --}}
    <div class="container w-100 p-4 mt-3">
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                    <input disabled type="text" class="form-control" value="Tipo de Comprobante:">
                </div>
            </div>

            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{ $compra->comprobante->tipo_comprobante }}">
            </div>
        </div>

        {{-- Numero de comprobante --}}
        <div class="row mb-2 ">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                    <input disabled type="text" class="form-control" value="Numero de Comprobante:">
                </div>
            </div>

            <div class="col-sm-8">
                <input disabled type="text" class="form-control" value="{{ $compra->numero_comprobante }}">
            </div>
        </div>

        {{-- Proveedor --}}
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input disabled type="text" class="form-control" value="Proveedor:">
                </div>
            </div>

            <div class="col-sm-8">
                <input disabled type="text" class="form-control"
                    value="{{ $compra->proveedore->persona->razon_social }}">
            </div>
        </div>

        {{-- Fecha --}}
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                    <input disabled type="text" class="form-control" value="Fecha:">
                </div>
            </div>

            <div class="col-sm-8">
                <input disabled type="text" class="form-control"
                    value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('d m Y') }}">
            </div>
        </div>

        {{-- Hora --}}
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                    <input disabled type="text" class="form-control" value="Hora:">
                </div>
            </div>

            <div class="col-sm-8">
                <input disabled type="text" class="form-control"
                    value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('H:i') }}">
            </div>
        </div>

        {{-- Impuesto --}}
        <div class="row mb-2">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                    <input disabled type="text" class="form-control" value="Impuesto:">
                </div>
            </div>

            <div class="col-sm-8 mb-4">
                <input id="input_impuesto" disabled type="text" class="form-control" value="{{ $compra->impuesto }}">
            </div>
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla: Detalle de compra
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead class="text-white bg-primary">
                        <tr>
                            <th class="rounded-start text-white">Producto</th>
                            <th class="text-white">Cantidad</th>
                            <th class="text-white">Precio de compra</th>
                            <th class="text-white">Precio de venta</th>
                            <th class="rounded-end text-white">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compra->productos as $item)
                            <tr>
                                <td class="rounded-start">{{ $item->nombre }}</td>
                                <td>{{ $item->pivot->cantidad }}</td>
                                <td>{{ $item->pivot->precio_compra }}</td>
                                <td>{{ $item->pivot->precio_venta }}</td>
                                <td class="td_subtotal" class="rounded-end">
                                    {{ $item->pivot->cantidad * $item->pivot->precio_compra }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th colspan="4">Suma: </th>
                            <th id="th_suma"></th>
                        </tr>
                        <tr>
                            <th colspan="4">IVA: </th>
                            <th id="th_iva"></th>
                        </tr>
                        <tr>
                            <th colspan="4">Total: </th>
                            <th id="th_total"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>



@endsection


@push('js')
    <script>
        let filaSubtotal = document.getElementsByClassName('td_subtotal');
        let cont = 0;
        let impuesto = $('#input_impuesto').val();

        $(document).ready(function() {
            calculaValores();
        });

        console.log(filaSubtotal);


        function calculaValores() {
            for (let i = 0; i < filaSubtotal.length; i++) {
                cont += parseFloat(filaSubtotal[i].innerHTML);
            }


            $('#th_suma').html('$' + cont.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('#th_iva').html('$' + parseFloat(impuesto).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('#th_total').html('$' + (parseFloat(impuesto) + cont).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }
    </script>
@endpush
