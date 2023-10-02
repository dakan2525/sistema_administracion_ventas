@extends('template')

@section('title', 'Panel')

@push('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Panel de análisis</h1>
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

            <div id="carouselExampleDark" class="carousel carousel-dark slide col-4">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <a href="{{ route('producto.index') }}"><img src="{{ asset('img/65venta.jpg') }}"
                                class="d-block w-100" alt="promo"></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="..." class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Second slide label</h5>
                            <p>Some representative placeholder content for the second slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="..." class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        @endsection

        @push('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script> --}}
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
            <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
        @endpush
