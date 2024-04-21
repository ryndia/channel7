@extends('master')

@section('css')
    @parent
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylev2.css') }}" rel="stylesheet">
    <!-- more css -->
@endsection

@section('navbar')
    @parent
    @include('navbar')
@endsection

@section('content')
  @parent
  @include('resource/widget_radio')
  @include('search_layout')
<!-- Main content goes here -->
@endsection

@section('footer')

@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('script/date.js') }}"></script>
    <script type="text/javascript" src="{{ asset('script/showMore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('script/audio_wave.js') }}"></script>
    <!-- replace js and add my own -->
    <!-- others js -->
@endsection