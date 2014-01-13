@extends('layouts.app')
@php
$dados['titulo']='ISAM | Entrar'
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center" style="padding-top:50px;">
        <div class="col-md-4">
            <img src="logo.png" class="center" style="height:100px; width:250px;">
            <div class="card card-login mx-auto mt-5" >
                <div class="card-header">Autenticação</div>

                <div class="card-body px-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" >Email:</label>


                                <input id="email" style="height:40px; font-size: 15px;" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group">
                            <label for="password" class="">Password:</label>

                                <input style="height:40px; font-size: 15px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember" style="padding-left:10px;">
                                         Manter a sessão iniciada
                                    </label>
                                </div>
                        </div>

                        <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary mb-5 mt-3" style="width:100%; height:40px; font-size: 15px;">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>




@endsection
