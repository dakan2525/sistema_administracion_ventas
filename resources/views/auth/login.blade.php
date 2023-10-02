<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Inicio de sesion del sistema" />
    <meta name="author" content="Dakan2525" />
    <title>Login - SB Admin</title>
    <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-white">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container bg-white">
                    @if ($errors->any())
                        <div class="col-12 container d-flex justify-content-sm-start pl-5 mx-3 mt-4 gap-2 flex-lg-wrap">
                            @foreach ($errors->all() as $error)
                                @if ($error == 'Credenciales incorrectas')
                                    <div class="alert col-12 alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <section class="gradient-form bg-white">
                        <div class="container py-2 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-xl-10">
                                    <div class="card rounded-3 text-black">
                                        <div class="row g-0">
                                            <div class="col-lg-6">
                                                <div class="card-body p-md-5 mx-md-4">

                                                    <div class="text-center">
                                                        <img src="{{ asset('img/logo-removebg-preview.png') }}"
                                                            style="width: 185px;" alt="logo">
                                                        <h4 class="mt-1 mb-5 pb-1">A&M</h4>
                                                    </div>
                                                    <form action="/login" method="POST">
                                                        @csrf

                                                        <div class="form-outline mb-4">
                                                            <label class="form-label" for="form2Example11">Correo
                                                                eléctrnico</label>
                                                            <input name="email" type="email" id="form2Example11"
                                                                class="form-control"
                                                                placeholder="Ingrese su correo eléctonico" />
                                                            @error('email')
                                                                <small class="text-danger">{{ '*' . $message }}</small>
                                                            @enderror
                                                        </div>


                                                        <div class="form-outline mb-4">
                                                            <label class="form-label"
                                                                for="form2Example22">Contraseña</label>
                                                            <input name="password" type="password" id="form2Example22"
                                                                class="form-control" />
                                                            @error('password')
                                                                <small class="text-danger">{{ '*' . $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="text-center pt-1 mb-5 pb-1">
                                                            <button
                                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                                type="submit">Iniciar sesión</button>
                                                            {{-- <a class="text-muted" href="#!">Forgot password?</a> --}}
                                                        </div>

                                                        {{-- <div
                                                            class="d-flex align-items-center justify-content-center pb-4">
                                                            <p class="mb-0 me-2">Don't have an account?</p>
                                                            <button type="button" class="btn btn-outline-danger">Create
                                                                new</button>
                                                        </div> --}}

                                                    </form>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-5 mb-lg-0 d-flex justify-content-center">
                                                <img src="{{ asset('img/anaqueles.png') }}"
                                                    class="w-100 rounded-4 shadow-4" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
            <div class="card-body">

            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>
        <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
