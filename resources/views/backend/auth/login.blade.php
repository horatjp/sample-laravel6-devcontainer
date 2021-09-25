@extends('backend.layout')

@section('title', 'ログイン')

@section('body')
<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">
        <h1 class="m-0 text-dark">{{ config('app.name') }}</h1>
    </div>

    <div class="card">

        <div class="card-body login-card-body">

            <p class="login-box-msg"></p>

            {!! Form::open() !!}

            @if ($errors->has('login'))
            <p class="alert alert-danger">
                <small>{!! $errors->first('login') !!}</small>
            </p>
            @endif

            <div class="form-group">

                <div class="input-group mb-3">
                    {!! Form::email('email', Request::old('email', ''), ['class' => 'form-control'.($errors->has('email')?' is-invalid':''), 'placeholder' => 'メールアドレス', '', 'autofocus']) !!}

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="input-group mb-3">
                    {!! Form::password('password', ['class' => 'form-control'.($errors->has('password')?' is-invalid':''), 'placeholder' => 'パスワード', '']) !!}

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-8">
                    <div class="icheck-belizehole">
                        {!! Form::checkbox('remember', 1, 1, ['id' => 'remember']) !!}
                        <label for="remember"><small>次回から省略する</small></label>
                    </div>
                </div>

                <div class="col-4 text-right">
                    <button type="submit" class="btn btn-primary btn-info btn-sm">ログイン</button>
                </div>

            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>

<script src="{{ asset('_backend/js/app.js') }}" defer></script>
</body>
@stop
