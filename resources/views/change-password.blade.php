@extends('layouts.app')
@section('content')
<style>
    #actual{
        background-color: rgb(146, 146, 146)
    }
    input {
    text-transform: none;
}
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">CAMBIA TU CONTRASEÑA</a> </div>
                    @if(session()->has('error'))
                        <span class="alert alert-danger">
                        <strong>{{ session()->get('error') }}</strong>
                    </span>
                    @endif
                    @if(session()->has('success'))
                        <span class="alert alert-success">
                        <strong>{{ session()->get('success') }}</strong>
                    </span>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('change.password') }}">
                            @csrf
                            

                            <div class="form-group row mt-2">
                                <label for="password" class="col-md-4 col-form-label text-md-right">NUEVA CONTRASEÑA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <label for="password" class="col-md-4 col-form-label text-md-right">CONFIRMAR NUEVA CONTRASEÑA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
                                    <button onClick="window.location.href=window.location.href" id="button" type="submit" class="btn btn-primary">
                                        CAMBIAR CONTRASEÑA
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
