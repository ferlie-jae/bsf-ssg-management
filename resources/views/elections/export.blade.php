@php
    $totalColumn = 2;
@endphp
<table border="1">
    <tr>
        <th colspan="2">Voters</th>
        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
            @php
                $position = App\Models\Configuration\Position::find($position);
                $totalColumn += $position->candidate_to_elect;
            @endphp
            <th colspan="{{ $position->candidate_to_elect }}">
                <b>{{ $position->name }}</b>
            </th>
        @endforeach
    </tr>
    @foreach ($gradeLevels as $gradeLevel => $sections)
        <tr>
            <td colspan="2">
                Grade {{ $gradeLevel }}
            </td>
        </tr>
        @foreach ($sections as $section)
            {{-- <tr>
                <td rowspan="{{ $section->students->count() + 1 }}">{{ $section->name }}</td>
            </tr> --}}
            @foreach ($section->students as $student)
                @php
                    $student = $student->student;
                @endphp
                <tr>
                    @if($loop->first)
                    <td rowspan="{{ $section->students->count() }}">{{ $section->name }}</td>
                    @endif
                    <td>
                        {{ $student->fullname('') }}
                    </td>
                    @isset ($student->user)
                        @foreach ($election->candidates->groupBy('position_id') as $position => $candidates)
                        @php
                            $position = App\Models\Configuration\Position::find($position);
                        @endphp
                            @if($position->candidate_to_elect > 1)
                                @if ($student->getVotedCandidate($election->id, $position) == false)
                                    @for ($i = 0; $i < $position->candidate_to_elect; $i++)
                                        <td>
                                            N/A
                                        </td>
                                    @endfor
                                @else
                                    @forelse ($student->getVotedCandidate($election->id, $position) as $voteData)
                                        <td>
                                            {{ $voteData->candidate->student->fullname('') }}
                                        </td>
                                    @empty
                                        @for ($i = 0; $i < $position->candidate_to_elect; $i++)
                                            <td>
                                                N/A
                                            </td>
                                        @endfor
                                    @endforelse
                                @endif
                            @else
                                <td>
                                    @if ($student->getVotedCandidate($election->id, $position) == false)
                                        N/A
                                    @else
                                        {{ $student->getVotedCandidate($election->id, $position)->candidate->student->fullname('') }}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    @else
                        <td>N/A</td>
                    @endisset
                </tr>
            @endforeach
        @endforeach
    @endforeach
</table>