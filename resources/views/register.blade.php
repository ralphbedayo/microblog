@extends('layouts/layout')
@section('title', env('APP_NAME'))

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@section('body')
    <div id="app" class="container">
        <div>
            <div style="padding-top: 150px" class="">
                <div class="row">
                    <div class="col-6 offset-3 shadow p-5 rounded rounded-3 ">
                        <h3 class="mb-4">Create a New Account</h3>

                        <form action="/register" method="post">
                            {{ csrf_field() }}

                            @error('system_error')
                            <div class="alert alert-danger">
                                <span>{{$message}}</span>
                            </div>
                            @enderror

                            @error('name')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="name" placeholder="Full Name"
                                       aria-label="Username"
                                       aria-describedby="basic-addon1">
                            </div>

                            @error('username')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                       aria-label="Username"
                                       aria-describedby="basic-addon1">
                            </div>

                            @error('password')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                            <div class="input-group mb-2">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="Password"
                                       aria-label="Password" aria-describedby="basic-addon1">
                            </div>

                            <div class="mt-1 w-100 d-flex">
                                <a class="ms-auto" href="/login"> Login instead</a>
                            </div>

                            <div class=" mt-4 w-100 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success w-75"><strong>Submit</strong></button>
                            </div>
                        </form>
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
