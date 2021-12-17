@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="p-5 text-center bg-image" style="background-image: url('{{ asset('images/website/achievements-banner.jpg') }}');height: 300px;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="mb-3">Achievements</h1>
            {{-- <h4 class="mb-3">asd</h4> --}}
            {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button"
            >Call to action</a
            > --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12">
            @if($achievements->count() > 0)
                <div class="accordion" id="accordionExample">
                    @foreach ($achievements as $achievement)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{ $achievement->id }}">
                                <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#achievement_{{ $achievement->id }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $achievement->title }}
                                </button>
                            </h2>
                            <div id="achievement_{{ $achievement->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading_{{ $achievement->id }}" data-mdb-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b>Published Date:</b> {{ date('F d, Y', strtotime($announcement->created_at)) }}
                                    <hr>
                                    {!! $achievement->content !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h1 class="text-center">No achievement yet</h1>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection