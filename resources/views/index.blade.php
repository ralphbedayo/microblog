@extends('layouts/layout')
@section('title', env('APP_NAME'))
@section('token_meta')
    <meta name="token" content="{{ $token }}">
@endsection

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@section('body')
    <div id="app"></div>
@endsection

@push('scripts')
{{--    <script src="{{ mix('js/vendor.js') }}"></script>--}}
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
