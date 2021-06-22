@extends('layouts.login_layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                    <div class="card-body">
                         <form method="POST" class="form-signin" action="{{ route('login') }}">
                                @csrf
                                <h2 class="form-signin-heading center">Увійти</h2>
                                <input type="text" class="form-control" name="email" placeholder="{{ __('E-Mail Address') }}" required="" autofocus="" />
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required=""/>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    Увійти
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                             <div class="card-footer text-center py-3">
                                 <div class="small"><a href="{{route('register')}}">Need an account? Sign up!</a></div>
                             </div>
                            </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
