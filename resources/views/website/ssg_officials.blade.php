@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="accordion" id="accordionExample">
                @forelse ($elections as $election)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading_{{ $election->id }}">
                            <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#election_{{ $election->id }}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $election->title }}
                            </button>
                        </h2>
                        <div id="election_{{ $election->id }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading_{{ $election->id }}" data-mdb-parent="#accordionExample">
                            <div class="accordion-body text-center">
                                @foreach ($election->candidates->groupBy('position_id') as $positionID => $candidates)
                                    @php
                                        $position = App\Models\Configuration\Position::find($positionID);
                                    @endphp
                                    <div class="form-group">
                                        <h4>
                                            {{ $position->name }}
                                        </h4>
                                        @if($election->getElectedCandidateByPosition($position->id) == False)
                                            <p>N/A</p>
                                        @else
                                            @if($position->candidate_to_elect > 1)
                                                <p>
                                                    @forelse ($election->getElectedCandidateByPosition($position->id) as $candidate)
                                                        {{ $candidate->student->fullname('') }}
                                                        <br>
                                                    @empty
                                                    <p>N/A</p>
                                                    @endforelse
                                                </p>
                                            @else
                                                <p>
                                                    {{ $election->getElectedCandidateByPosition($position->id)->student->fullname('') }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                <br>
                <br>
                <br>
                <br>
                <br>
                <h1 class="text-center mt-5 mb-5">No SSG Officers yet</h1>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection