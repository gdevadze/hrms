<table style="width:100%;text-align: center !important;">
        <tr>

            <th style="width: 50px;" rowspan="2">#</th>
            <th rowspan="2">თანამშრომელი</th>

        </tr>
        <tr style="width: 200px !important;">
            @for($i = 1; $i <= $month_days; $i++)
                <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT).'.'.$month.'.'.$year }}</th>
            @endfor
            <th >ხელმოწერა</th>
        </tr>


        @foreach($users as $key => $user)
            <tr>
                <td>{{ $key+1 }}</td>

                <td>{{ $user->user->full_name_en }}</td>
                @for($i = 1; $i <= $month_days; $i++)
                    @php
                        $dynamicWorkingSchedule = \App\Models\DynamicWorkingSchedule::where('user_id',$user->user_id)->where('date',$year.'-'.$month.'-'.$i)->first()
                    @endphp

                    <td style="width: 200px !important;">
                        <b>
                            <font face="Sylfaen" color="#000000">
                                @if(isset($dynamicWorkingSchedule) && $dynamicWorkingSchedule->dynamic_working_schedule_time)
                                    @if($dynamicWorkingSchedule->dynamic_working_schedule_time_id == 1)
                                        X
                                    @else
                                        {{ \Carbon\Carbon::parse($dynamicWorkingSchedule->dynamic_working_schedule_time->start_time)->format('H:i').' - '.\Carbon\Carbon::parse($dynamicWorkingSchedule->dynamic_working_schedule_time->end_time)->format('H:i') ?? '' }}
                                    @endif

                                @endif
                            </font>
                        </b>
                    </td>
                @endfor
                <td></td>
            </tr>

        @endforeach

    </table>

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
