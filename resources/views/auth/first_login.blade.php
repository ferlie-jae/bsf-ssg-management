<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h1">Binmaley School of Fisheries Management</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Welcome {{ Auth::user()->student->student->first_name }}, please update your email.</p>
                    <form action="{{ route('users.update_email', Auth::user()->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="input-group mb-3">
                            <input id="email" placeholder="Username" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('AdminLTE-3.1.0/dist/js/adminlte.min.js') }}"></script>
        <script type="application/javascript">
            $(function() {
                /*$(document).on('click', '.btn-submit-out', function() {
                    $(this).prop('disabled', true).append(' <i class="fa fa-spinner fa-pulse"></i>');
                    $($(this).data('submit')).submit();
                });*/
        
                $(document).on('submit', 'form', function(){
                    $(this).find('button[type=submit]').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
                })
            });
        </script>
    </body>
</html>