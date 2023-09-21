@extends('template')

@section('title', 'Perfil')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

    @if (session('success'))
        <script>
            let message = "{{ session('success') }}"
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        </script>
    @endif

    <div class="container">
        <h1 class="mt-4 text-center">Configurar perfil</h1>


        <div class="container card">
            <form class="card-body" action="{{ route('profile.update', ['profile' => $user]) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- nombre --}}
                <div class="row my-4">
                    <div class="col-sm-4 ">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input type="text" disabled class="form-control" value="Nombres">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}">
                        <div class="col-sm-8 ">
                            @error('name')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>


                </div>

                {{-- email --}}
                <div class="row my-4">
                    <div class="col-sm-4 ">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input type="email" disabled class="form-control" value="Correo eléctronico">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}">
                        <div class="col-sm-8 ">
                            @error('email')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- password --}}
                <div class="row my-4">
                    <div class="col-sm-4 ">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                            <input type="text" disabled class="form-control" value="Contraseña">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="col-sm-3 ">
                            @error('password')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- boton --}}
                <div class="col-sm-12 text-center">
                    <input class="btn btn-success" type="submit" value="Guardar cambios">
                </div>

        </div>
        </form>
    </div>

@endsection

@push('js')
@endpush
