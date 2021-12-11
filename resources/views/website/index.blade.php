@extends('layouts.website')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="homeCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-mdb-ride="carousel">
                <div class="carousel-indicators">
                    <button
                      type="button"
                      data-mdb-target="#homeCarousel"
                      data-mdb-slide-to="0"
                      class="active"
                      aria-current="true"
                      aria-label="Slide 1"></button>
                    <button
                      type="button"
                      data-mdb-target="#homeCarousel"
                      data-mdb-slide-to="1"
                      aria-label="Slide 2"></button>
                    <button
                      type="button"
                      data-mdb-target="#homeCarousel"
                      data-mdb-slide-to="2"
                      aria-label="Slide 3"></button>
                    <button
                      type="button"
                      data-mdb-target="#homeCarousel"
                      data-mdb-slide-to="3"
                      aria-label="Slide 4"></button>
                    <button
                      type="button"
                      data-mdb-target="#homeCarousel"
                      data-mdb-slide-to="4"
                      aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('images/carousel/carousel-1.jpg') }}">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/carousel/carousel-2.jpg') }}">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/carousel/carousel-3.jpg') }}">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/carousel/carousel-4.jpg') }}">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/carousel/carousel-5.jpg') }}">
                    </div>
                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-mdb-target="#homeCarousel"
                    data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-mdb-target="#homeCarousel"
                    data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            
        </div>
    </div>
</div>
@endsection
@section('script')
    {{-- <script>
        $('.carousel').carousel({
            interval: 5000,
            pause: false
        })
    </script> --}}
@endsection