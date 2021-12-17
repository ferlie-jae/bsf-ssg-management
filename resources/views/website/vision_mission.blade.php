@extends('layouts.website')
@section('content')
<div class="container text-center mt-3 mb-5 pb-5">
   
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img class="img-fluid" width="250px" src="{{ asset('images/logo.png') }}" alt="">
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Vision</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h5 style="font-weight: 200">
                We dream of students who passionately love their school and their country and whose values and competencies enable them to realize their full potential
                and contribute meaningfully to building the nation through student's leadership
            </h5>
        </div>
    </div>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Mission</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h5 style="font-weight: 200">
                To present the interest of the student body through initiatives, programs, and services that enrich students lives.
            </h5>
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script src="{{ asset('MDBootstrap-5-v2.0.0/src/js/mdb.pro.js') }}"></script> --}}
@endsection