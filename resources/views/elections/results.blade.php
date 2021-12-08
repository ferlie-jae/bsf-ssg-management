@extends('layouts.adminlte')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Results
                </h1>
            </div>
            <!-- /.col -->
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v2</li>
                </ol>
            </div> --}}
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="accordion">
                @forelse ($elections as $election)
                    @isset($election->id)
                    <div class="card card-success card-outline">
                        <a class="d-block" data-toggle="collapse" href="#election-{{ $election->id }}">
                            <div class="card-header text-dark">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">
                                        {{ $election->title }}
                                    </h4>
                                    <span>
                                        <label>Date:</label>
                                        {{ date('F d, Y', strtotime($election->end_date)) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div id="election-{{ $election->id }}" class="collapse @if($loop->first) show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <div class="row">
                                        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header border-0">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="card-title">{{ App\Models\Configuration\Position::find($position)->name }}</h3>
                                                            {{-- <a href="javascript:void(0);">View Report</a> --}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="position-relative mb-4">
                                                                    {!! $electionChart[$election->id][$position]->container() !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="position-relative mb-4">
                                                                    {!! $electionPieChart[$election->id][$position]->container() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endisset
                @empty
                <h3 class="text-center text-danger">No Election Yet</h3>
                @endforelse
            </div>
            {{-- <div class="col-lg-12">
                    {!! $patientChart->container() !!}
                </div> --}}
        </div>
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"></div>
                </div>
            </div>
        </div> --}}
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('script')
    <script src="{{ asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.js') }}"></script>
    @foreach ($elections as $election)
        @isset($election->id)
            @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                {!! $electionChart[$election->id][$position]->script() !!}
                {!! $electionPieChart[$election->id][$position]->script() !!}
            @endforeach
        @endisset
    @endforeach
@endsection