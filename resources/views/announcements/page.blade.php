@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col text-center">
                <h1 class="m-0">Achievements</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @foreach ($achievements as $achievement)
                    <div class="card card-success card-outline">
                        <a class="d-block w-100" data-toggle="collapse" href="#achievement-{{ $achievement->id }}">
                            <div class="card-header">
                                <h4 class="card-title w-100 text-dark">
                                    {{ $achievement->title }}
                                </h4>
                            </div>
                        </a>
                        <div id="achievement-{{ $achievement->id }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                            <div class="card-body">
                                {!! $achievement->content !!}
                                <br>
                                <label>Date Published:</label>
                                {{ date('F d, Y h:i A', strtotime($achievement->created_at)) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
