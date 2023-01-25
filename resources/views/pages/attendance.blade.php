
    <table class=" table-sm table-bordered table-striped table-hover datatable">
        <thead>
        <tr>
            <th style="width: 85px">Students/Days</th>
            @for($i = 1; $i <= $daysInMonth; $i++)
                <th style="width: 5px">{{ $i }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @foreach($movements as $student)
            <tr>
                <td>{{ $student->user->name }} {{ $student->last_name }}</td>
                @for($i = 1; $i <= $daysInMonth; $i++)
                    <td style="width: 5px">
                        <input
                            type="checkbox"
                            name="student_{{ $student->id }}[]"
                            value=""
                            @if(\Carbon\Carbon::parse($student->start_date)->format('d') == $i)
                                checked
                                @endif

                        >
                    </td>
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
