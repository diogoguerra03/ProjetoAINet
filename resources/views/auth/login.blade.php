@extends('layouts.footer')
@extends('layouts.app')
@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-auto">
                                <a class="bi bi-caret-left-fill" href="/"></a>
                            </div>
                            <div class="col text-center">
                                <span>{{ __('Login') }}</span>
                            </div>

                        </div>

                    </div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            <a href="{{ url('/') }}"
                                onclick="event.preventDefault(); window.location.href='{{ url('/') }}';">
                                <img class="rounded-5 mx-auto d-block" style="height: 200px;"
                                    src="{{ asset('assets/images/logos/imagineshirt.png') }}" alt="Shirt Image">
                            </a>
                            @csrf
                            <div class="row mb-3 mx-auto">
                                <div class="col-md-6 mx-auto">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
    value="{{ old('email', $rememberedEmail) }}" placeholder="Email Address" required autocomplete="email" autofocus>


                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mx-auto">
                                <div class="col-md-6 mx-auto">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="d-flex ">
                                    <div class="form-check mx-auto">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mx-auto" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex">
                                <span class="ml-3 mx-auto mb-4"> Don't have an account? <a
                                        href="{{ route('register') }}">{{ __('Register') }}</a> </span>
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mx-auto btn-lg">
                                        {{ __('Login') }}
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
