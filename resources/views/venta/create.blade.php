@extends('template')

@section('title', 'Crear venta')

@push('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Realizar venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('venta.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Realizar venta</li>
        </ol>
    </div>
    <form action="{{ route('venta.store') }}" method="POST">
        @csrf
        <div class="container mt-4">
            <div class="row gy-4">
                {{-- venta_producto --}}
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center rounded-top">
                        Detalles de la venta
                    </div>
                    <div class="p-3 border border-3 border-primary rounded-bottom">

                        <div class="col-md-12 row">
                            {{-- producto --}}
                            <div class="col-md-10 mb-2">
                                <select class="form-control selectpicker" name="producto_id" id="producto_id"
                                    data-live-search="true" title="Busque el producto aquí" data-size="3">
                                    @foreach ($productos as $producto)
                                        <option
                                            value="{{ $producto->id }}-{{ $producto->stock }}-{{ $producto->precio_venta }}">
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Stock --}}
                            <div class="col-md-2 mb-4  fw-semibold">
                                {{-- <label for="idStock" class="form-label"></label> --}}
                                <input disabled type="text" class="form-control" id="stock">

                            </div>
                        </div>

                        <div class="row">
                            {{-- cantidad --}}
                            <div class="col-md-2 mb-4">
                                <label for="cantidad" class="form-label">Cantidad: </label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            {{-- precio_venta --}}
                            <div class="col-md-4 mb-4">
                                <label for="precio_venta" class="form-label">Precio de venta: </label>
                                <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control"
                                    step="0.1">
                            </div>

                            {{-- Descuento --}}
                            <div class="col-md-4 mb-4">
                                <label for="descuento" class="form-label">Descuento: </label>
                                <input type="number" name="descuento" id="descuento" class="form-control">
                            </div>

                            {{-- boton agregar --}}
                            <div class="col-md-2 mt-4 text-center p-2">
                                <button id="btn_agregar" type="button" class="btn btn-primary">Agregar</button>
                            </div>

                            {{-- tabla para detalle de la venta --}}
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="bg-primary ">
                                            <tr>
                                                <th class="text-white rounded-start">#</th>
                                                <th class="text-white">Producto</th>
                                                <th class="text-white">Cantidad</th>
                                                <th class="text-white">Precio venta</th>
                                                <th class="text-white">Descuento</th>
                                                <th class="text-white">Subtotal</th>
                                                <th class="text-white rounded-end"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Sumas</th>
                                                <th colspan="2"><span id="sumas">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">IVA %</th>
                                                <th colspan="2"><span id="iva">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Total</th>
                                                <th colspan="2"><input type="hidden" name="total" value="0"
                                                        id="inputTotal"><span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            {{-- boton para cancelar la venta --}}
                            <div class="col-md-12 mb-2">
                                <button id="cancelar" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" type="button">Cancelar venta</button>
                            </div>

                        </div>
                    </div>
                </div>


                {{-- Venta --}}
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center rounded-top">Datos generales</div>

                    <div class="p-3 border border-3 border-success rounded-bottom ">
                        <div class="row">

                            {{-- cliente --}}
                            <div class="col-md-12 mb-2">
                                <label for="cliente_id" class="form-label">Cliente: </label>
                                <select class="form-control selectpicker show-tick" data-size='3' title="Selecciona"
                                    data-live-search="true" name="cliente_id" id="cliente_id">
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->persona->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            {{-- tipo de comprobante --}}
                            <div class="col-md-12 mb-2">
                                <label for="comprobante_id" class="form-label">Tipo de comprobante: </label>
                                <select class="form-control selectpicker show-tick" data-size='3' title="Selecciona"
                                    name="comprobante_id" id="comprobante_id">
                                    @foreach ($comprobantes as $comprobante)
                                        <option value="{{ $comprobante->id }}">{{ $comprobante->tipo_comprobante }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('comprobante_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            {{-- numero comprobante --}}
                            <div class="col-md-12 mb-4">
                                <label for="numero_comprobante" class="form-label">Numero de comprobante: </label>
                                <input required type="text" name="numero_comprobante" id="numero_comprobante"
                                    class="form-control">
                                @error('numero_comprobante')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            {{-- impuesto --}}
                            <div class="col-md-6 mb-4">
                                <label for="impuesto" class="form-label">Impuesto: </label>
                                <input readonly type="text" name="impuesto" id="impuesto"
                                    class="form-control border-success">
                                @error('impuesto')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            {{-- fecha --}}
                            <div class="col-md-6 mb-2">
                                <label for="fecha" class="form-label">Fecha: </label>
                                <input readonly type="date" name="fecha" id="fecha"
                                    class="form-control border-success" value="<?php echo date('Y-m-d'); ?>">

                                <?php
                                //php para guardar la hora y enviarla a guardar
                                use Carbon\Carbon;
                                $fecha_hora = Carbon::now()->toDateTimeString();
                                ?>
                                <input type="hidden" name="fecha_hora" value="{{ $fecha_hora }}">

                            </div>

                            {{-- user_id --}}
                            <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="col-md-12 mb-2 text-center">
                                <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para cancelar la venta-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar venta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quieres cancelar la venta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnCancelarVenta" type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        //variables 
        let contador = 0;
        let subtotal = [];
        let sumas = 0;
        let iva = 0;
        let total = 0;

        //constantes
        const impuesto = 18;


        $(document).ready(function() {

            $('#producto_id').change(mostrarValores);

            $('#btn_agregar').click(function() {
                agregarProducto();
            });

            $('#btnCancelarVenta').click(function() {
                cancelarVenta();
                disableButtons();
            });

            disableButtons();
            $('#impuesto').val(impuesto + '%');
        });


        function mostrarValores() {
            let dataProducto = document.getElementById('producto_id').value.split('-');
            $('#stock').val(dataProducto[1]);
            $('#precio_venta').val(dataProducto[2])
        }

        function agregarProducto() {

            let dataProducto = document.getElementById('producto_id').value.split('-');

            let idProducto = dataProducto[0];
            let nameProducto = $('#producto_id option:selected').text();
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();
            let descuento = $('#descuento').val();
            let stock = $('#stock').val();

            if (descuento == '') {
                descuento = 0;
            }
            //valudaciones
            //campos no esten vacios
            if (idProducto != '' && cantidad != '') {
                //validar datos ingresados 
                if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {
                    // cantidad pedida no supere el stock
                    if (parseInt(cantidad) <= parseInt(stock)) {

                        //calcular valores
                        subtotal[contador] = (cantidad * precioVenta - descuento);
                        sumas += (subtotal[contador]);
                        iva = (sumas / 100 * impuesto);
                        total = (sumas + iva);

                        let fila = '<tr id="fila' + contador + '">' +
                            '<th>' + (contador + 1) + '</th>' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' +
                            nameProducto +
                            '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad +
                            '</td>' +
                            '<th><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                            precioVenta +
                            '</th>' +
                            '<th><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' +
                            descuento +
                            '</th>' +
                            '<td>' + subtotal[contador] + '</td>' +
                            '<td><button onClick="eliminarProducto(' + contador +
                            ')" class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i></button></td>' +
                            '</tr>';

                        //acciones despues de añadir fila
                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        contador++;
                        disableButtons();

                        //mostrar los campos calculados
                        $('#sumas').html(sumas.toFixed(2));
                        $('#iva').html(iva.toFixed(2));
                        $('#total').html(total.toFixed(2));
                        $('#impuesto').val(iva.toFixed(2));
                        $('#inputTotal').val(total.toFixed(2));


                    } else {
                        showModal('Cantidad incorrecta')
                    }
                } else {
                    showModal('Los valores son incorrectos')
                }

            } else {

                //modal
                showModal('Le faltan campos por llenar')
            }

        }

        function limpiarCampos() {
            let select = $('#producto_id');
            select.selectpicker();
            select.selectpicker('val', '');
            $('#cantidad').val('');
            $('#precio_venta').val('');
            $('#descuento').val('');
            $('#stock').val('');
        }

        function disableButtons() {
            if (total == 0) {
                $('#guardar').hide();
                $('#cancelar').hide();
            } else {
                $('#guardar').show();
                $('#cancelar').show();
            }
        }


        function showModal(message, icon = 'error') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: message
            })
        }

        function eliminarProducto(indice) {
            //calcular valores menos la fila eliminada
            sumas -= subtotal[indice];
            iva = sumas / 100 * impuesto;
            total = sumas + iva;

            //mostrar los campos calculado
            $('#sumas').html(sumas.toFixed(2));
            $('#iva').html(iva.toFixed(2));
            $('#total').html(total.toFixed(2));
            $('#impuesto').val(iva.toFixed(2));
            $('#inputTotal').val(total.toFixed(2));

            //eliminar fila de la tabla 
            $('#fila' + indice).remove();
            disableButtons();
        }

        function cancelarVenta() {
            $('#tabla_detalle > tbody').empty();

            //agregar una fila en blanco
            let fila = '<tr>' +
                '<th></th>' +
                '<td></td>' +
                '<th></th>' +
                '<td></td>' +
                '<th></th>' +
                '<td></td>' +
                '<th></th>' +
                '</tr>';
            $('#tabla_detalle').append(fila);

            //reiniciar las variables
            contador = 0;
            subtotal = [];
            sumas = 0;
            iva = 0;
            total = 0;

            //mostrar los campos calculados
            $('#sumas').html(sumas.toFixed(2));
            $('#iva').html(iva.toFixed(2));
            $('#total').html(total.toFixed(2));
            $('#impuesto').val(impuesto + '%');
            $('#inputTotal').val(total.toFixed(2));

            limpiarCampos();
            disableButtons();
        }
    </script>
@endpush
