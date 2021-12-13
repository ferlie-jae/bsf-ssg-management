@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="p-5 text-center bg-image" style="background-image: url('{{ asset('images/website/pond-edit.jpg') }}');height: 300px;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="mb-3">Campus News</h1>
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
            @if($announcements->count() > 0)
                <div class="accordion" id="accordionExample">
                    @foreach ($announcements as $announcement)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{ $announcement->id }}">
                                <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#announcement_{{ $announcement->id }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $announcement->title }}
                                </button>
                            </h2>
                            <div id="announcement_{{ $announcement->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading_{{ $announcement->id }}" data-mdb-parent="#accordionExample">
                                <div class="accordion-body text-center">
                                    {!! $announcement->content !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h1 class="text-center">No announcement yet</h1>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection