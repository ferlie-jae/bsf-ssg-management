@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="p-5 text-center bg-image" style="background-image: url('{{ asset('images/website/courses-banner.jpg') }}');height: 300px;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="mb-3">Courses Offered</h1>
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
            <div class="text-center bg-transparent">
                <h1 class="mb-3">Senior High School</h1>
                <h4>Academic Track</h4>
                <ul style="list-style: none">
                    <li>HUMMS</li>
                    <li>STEM</li>
                </ul>
                <h4>TVL Track</h4>
                <ul style="list-style: none">
                    <li>Cookery/ Home Economics</li>
                    <li>ICT</li>
                    <li>Aquaculture</li>
                </ul>
            </div>
            <div class="p-5 text-center bg-transparent">
                <h1 class="mb-3">Junior High School</h1>
                <ul style="list-style: none">
                    <li>Fish culture</li>
                    <li>Fish preservation</li>
                </ul>
            </div>
            {{-- <ul>
                <li>
                    Academic Track
                    <ul>
                        <li>HUMMS</li>
                        <li>STEM</li>
                    </ul>
                </li>
            </ul> --}}
            {{-- <div class="accordion" id="coursesOffered_accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading">
                        <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#election" aria-expanded="true" aria-controls="collapseOne">
                            Academic Track
                        </button>
                    </h2>
                    <div id="election" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading" data-mdb-parent="#coursesOffered_accordion">
                        <div class="accordion-body text-center">
                            
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection