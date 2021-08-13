@extends('layouts/layout')
@section('title', env('APP_NAME'))

{{-- @push('styles') --}}
{{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
{{-- @endpush --}}

@section('body')
    <div id="app">
        <div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <form action="/login" method="post">
                {{ csrf_field() }}
                <label>
                    Username
                    <input type="text" name="username">
                </label>
                <label for="password">Password</label> <input type="password" name="password" id="password">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="{{ mix('js/vendor.js') }}"></script>--}}
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
