@extends('template')

@section('title', 'Panel')

@push('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Panel de analisis</h1>
        <ol class="breadcrumb mb-4">
            <?php
            //php para guardar la hora y enviarla a guardar
            use Carbon\Carbon;
            $fecha = Carbon::now();
            ?>
            <li class="breadcrumb-item active">{{ $fecha }}</li>
        </ol>
        <div class="row">
            {{-- clientes --}}
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 mt-2">
                                <i class="fa-solid fa-user-tag px-2 fs-5"></i><span class="px-2 fs-5">Clientes</span>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                use App\Models\Cliente;
                                $clientes = count(Cliente::all());
                                ?>
                                <p class="text-start fw-bold fs-3">{{ $clientes }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small fs-5 text-white stretched-link text-decoration-none"
                            href="{{ route('cliente.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            {{-- ventas --}}
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 mt-2">
                                <i class="fa-solid fa-tag px-2 fs-5"></i><span class="px-2 fs-5">Ventas</span>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                use App\Models\Venta;
                                $venta = count(Venta::all());
                                ?>
                                <p class="text-start fw-bold fs-3">{{ $venta }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small fs-5 text-white stretched-link text-decoration-none"
                            href="{{ route('venta.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            {{-- compras --}}
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 mt-2">
                                <i class="fa-solid fa-file-invoice-dollar px-2 fs-5"></i><span
                                    class="px-2 fs-5">Compras</span>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                use App\Models\Compra;
                                $compras = count(Compra::all());
                                ?>
                                <p class="text-start fw-bold fs-3">{{ $compras }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small fs-5 text-white stretched-link text-decoration-none"
                            href="{{ route('compra.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            {{-- Productos --}}
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 mt-2">
                                <i class="fa-solid fa-people-group px-2 fs-5"></i><span class="px-2 fs-5">Productos</span>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                use App\Models\Producto;
                                $productos = count(Producto::all());
                                ?>
                                <p class="text-start fw-bold fs-3">{{ $productos }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small fs-5 text-white stretched-link text-decoration-none"
                            href="{{ route('producto.index') }}">Ver más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
        <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    @endpush
