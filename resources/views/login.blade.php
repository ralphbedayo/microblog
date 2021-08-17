@extends('layouts/layout')
@section('title', env('APP_NAME'))

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .login-divider {
            align-items: center;
            border-bottom: 1px solid #dadde1;
            display: flex;
            margin: 20px -15px;
            text-align: center;
        }
    </style>
@endpush

@section('body')
    <div id="app" class="container">
        <div>
            <div style="padding-top: 150px" class="">
                <div class="row">
                    <div class="col-4">
                        <div class="d-flex">
                            <h1 class="ms-auto">Blog Spotter</h1>
                        </div>
                    </div>
                    <div class="col-4 offset-3 shadow p-5 rounded rounded-3 ">
                        <form action="/login" method="post">
                            {{ csrf_field() }}

                            @error('username')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                       aria-label="Username"
                                       aria-describedby="basic-addon1" required>
                            </div>

                            @error('password')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                            <div class="input-group mb-4">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="Password"
                                       aria-label="Password" aria-describedby="basic-addon1" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><strong>Login</strong></button>
                        </form>

                        <div class="login-divider"></div>

                        <div class="w-100 d-flex justify-content-center">
                            <a href="/register" class="btn btn-success w-75 "><strong>Sign Up</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/manifest.js')}}"></script>
    <script src="{{ mix('js/vendor.js')}}"></script>
@endpush
