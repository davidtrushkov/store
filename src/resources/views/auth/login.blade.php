@extends('app')

@section('content')

    <div class="container-fluid" id="Login-Register-Container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                <div class="panel panel-default" id="Login-Register-Panel">
                    <div class="panel-body">
                        <h4 class="text-center" id="log-in">Log In</h4>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('auth.login') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-10 col-md-offset-1">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-10 col-md-offset-1">
                                    <input type="password" class="form-control" name="password" placeholder="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3 text-center">
                                    <button type="submit" class="btn btn-default btn-rounded waves-effect waves-light btn-block">Login</button>
                                </div>
                                <div class="col-md-12">
                                <a href="{{ url('password/email') }}" class="center-block text-center" id="Forgot-Password">Forgot Password?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p id="No-Account" class="center-block text-center">Don't have an account? <a href="{{ url('/register') }}" id="Sign-up">Register</a></p>
                <div class="panel panel-default" id="Login-Register-Panel" style="padding: 20px">
                    <h6 class="text-center">Login as Test Admin User</h6>
                    <h6 class="text-center">Email: test@hotmail.com</h6>
                    <h6 class="text-center">Password: test123</h6>
                </div>
            </div>
        </div>
    </div>
@endsection
