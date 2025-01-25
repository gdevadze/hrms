<div class="table-responsive">
    <table border="0" cellpadding="0" cellspacing="0" width="465">
        <colgroup>
            <col width="151"/>
            <col width="81" span="3"/>
            <col width="71"/>
        </colgroup>
        <tbody>
        <!-- Table header with dates for each day -->
        @php
            // Create a collection of all dates in the range
            $dateRange = collect();
            $currentDate = $start->copy();

            while ($currentDate->lte($end)) {
                $dateRange->push($currentDate->copy());
                $currentDate->addDay();
            }
        @endphp
        <tr height="20">
            <td >#</td>
            @foreach ($dateRange as $date)
                <td scope="col" class="date-clickable" data-date="{{ $date->format('Y-m-d') }}">{{ weekDayName($date->year, $date->month, $date->day) }}<br>{{ $date->translatedFormat('d M') }}</td>
            @endforeach
        </tr>

        <!-- Data rows for each user -->
        @foreach($users as $key => $user)
            <tr>
                <td rowspan="2">{{ $user['full_name'] }}</td>
                @foreach($user->movements()->whereDate('start_date','>=',$startDate)->whereDate('start_date','<=',$endDate)->get() as $res)
                    @foreach ($dateRange as $date)
                        @if($date->format('Y-m-d') == \Carbon\Carbon::parse($res->start_date)->format('Y-m-d'))
                            <td align="right">{{ $date->format('Y-m-d') }}</td>
                            <td align="right">{{ \Carbon\Carbon::parse($res->start_date)->format('Y-m-d') }}</td>
                        @else
                            <td align="right">დ</td>
                            <td align="right">დ</td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach($user->movements()->whereDate('start_date','>=',$startDate)->whereDate('start_date','<=',$endDate)->get() as $res)
                    <td colspan="2" height="20">0</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

    <style>
        td {
            border: 1px solid #00000052;
        }
    </style>
</div>
