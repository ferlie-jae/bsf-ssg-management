<table border="1">
    <tr>
        <th></th>
        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
        @php
            $position = App\Models\Configuration\Position::find($position);
        @endphp
        <th colspan="{{ $candidates->count() }}">
            <b>{{ $position->name }}</b>
        </th>
        @endforeach
    </tr>
    <tr>
        <th>Voter</th>
        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
            @foreach ($candidates as $candidate)
                <th>
                    {{ $candidate->student->fullname('') }}
                </th>
            @endforeach
        @endforeach
    </tr>
    @foreach ($votes as $vote)
        <tr>
            <th>
                @if($vote->user->student)
                {{ $vote->user->student->student->getStudentName($vote->user->student->student_id) }}
                @elseif($vote->user->faculty)
                {{ $vote->user->faculty->student->getFacultyName($vote->user->faculty->faculty_id) }}
                @endif
            </th>
            @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                @foreach ($candidates as $candidate)
                    <th>
                        @if($vote->isVotedCandidate($candidate->id))
                            ✔
                        @endif
                    </th>
                @endforeach
            @endforeach
        </tr>
    @endforeach
</table>