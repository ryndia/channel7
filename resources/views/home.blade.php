@extends('master')

@section('css')
    @parent
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylev2.css') }}" rel="stylesheet">
    <!-- more css -->
@endsection
 <x-smart-ad-component slug="banner"/> 
@section('navbar')
    @parent
    @include('navbar')
@endsection

@section('content')
  @parent
  @include('resource/widget_radio')
  @include('layout_4')
<!-- Main content goes here -->
@endsection

@section('footer')
 @include('footer')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('script/date.js') }}"></script>
    <script type="text/javascript" src="{{ asset('script/showMoare.js') }}"></script>
    <!-- replace js and add my own -->
    <!-- others js -->
@endsection