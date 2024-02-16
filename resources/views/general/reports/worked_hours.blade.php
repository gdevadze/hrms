<div class="table-responsive">

    <table style="width:100%;text-align: center !important;">
        <tr>

            <th style="width: 50px;" rowspan="2">#</th>
            <th rowspan="2">თანამშრომელი</th>
            <th rowspan="2">თანამდებობა</th>
            <th rowspan="2">ტაბულის ნომერი/პირადი ნომერი</th>
            <th colspan="{{ $month_days }}">აღნიშვნები სამუშაოზე გამოცხადების შესახებ, თარიღების მიხედვით თვის განმავლობაში(სთ)</th>
            <th colspan="3" style="text-align: center">სულ ნამუშევრები თვის განმავლობაში</th>

        </tr>
        <tr>
            @for($i = 1; $i <= $month_days; $i++)
                <th colspan="1" style="height: 110px; width: 20px !important;">{{ $i }}</th>
            @endfor
            <th rowspan="1">დღე</th>
            <th>ჯამი</th>
            <th>დასვენების <br> დღეები</th>

        </tr>

        @foreach($users as $key => $user)
        <tr style="height: 90px;">
            <td>{{ $key+1 }}</td>

            <td>{{ $user['data']['full_name'] }}</td>
            <td>{{ $user['data']['position_title'] }}</td>
            <td>{{ $user['data']['personal_num'] }}</td>
            @php
                $totalWorkedHours = 0;
                $totalWorkedDays = 0;
                $totalHolidays = 0;
            @endphp
            @foreach($user['result'] as $res)
                <td><b>
                        <font face="Sylfaen" color="#000000">
                            @isset($res['value'])
                                @if($res['value'] == '')
                                    {{ $res['worked_hours'] }}
                                @else

                                    {{ $res['value'] }}

                                @endif
                            @endisset
                        </font>
                    </b></td>
                @php
                if(isset($res['value']) && ($res['value'] == 'დ' || $res['value'] == 'X')){
                    $totalHolidays += 1;
                }
                @endphp
            @endforeach

            <td><center>{{ $user['data']['must_working_days'] }}</center></td>
            <td><center>{{ $user['data']['summary_worked_hours'] }}</center></td>
            <td><center>{{ $totalHolidays }}</center></td>

        </tr>

        @endforeach



    </table>

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</div>
