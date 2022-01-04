@extends('layouts.adminlte')
@section('content')
<section class="content">
    <div class="container-fluid text-center">
        @foreach ($positions as $position)
            <div class="form-group">
                <h3>
                    {{ $position->name }}
                </h3>
                @if($position->electedOfficer() == False)
                    <p>N/A</p>
                @else
                    @if($position->candidate_to_elect > 1)
                        <p>
                            @forelse ($position->electedOfficer() as $candidate)
                                {{ $candidate->student->fullname('') }}
                                <br>
                            @empty
                            <p>N/A</p>
                            @endforelse
                        </p>
                    @else
                        <p>
                            {{ $position->electedOfficer()->student->fullname('') }}
                        </p>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</section>
@endsection