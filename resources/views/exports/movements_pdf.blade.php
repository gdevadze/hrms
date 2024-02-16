<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
    <title>Report - {{ $user->personal_num }}</title>
</head>
<body>

<table>

    <tr>
        <td colspan="3">
            სახელი, გვარი: {{ $user['full_name'] }}
            <br>
            <br>
            ტელ: {{ $user['tel'] }}
        </td>
        <td colspan="2">
            პირადი ნომერი: {{ $user['personal_num'] }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>@lang('day')</td>
        <td>@lang('start')</td>
        <td>@lang('finish')</td>
        <td>@lang('hours_worked')</td>

    </tr>
    @foreach($user['movements'] as $key => $movement)

        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $movement->week_day_name }}</td>
            <td>
                @if($movement->checkUser($user['working_schedule']['week_days']))
                    <span >{{ $movement->formatted_start_date }}</span>
                @else
                    <span>{{ $movement->formatted_start_date }}</span>
                @endif
            </td>
            <td>
                @if($movement->checkUser($user['working_schedule']['week_days'],true))
                    <span >{{ $movement->formatted_end_date }}</span>
                @else
                    <span >{{ $movement->formatted_end_date }}</span>
                @endif
            </td>
            <td>{{ $movement->worked_hours['hours'] }}</td>
        </tr>

    @endforeach

    <!--<tr>-->
    <!--    <td colspan="5">-->
    <!--        @lang('workdays'):<b class="text-danger"> {{ $workingAndMissedDays['working_days'] }}</b>, @lang('to_miss'):<b class="text-danger"> {{ $workingAndMissedDays['missed_days'] }}</b>, @lang('late'):<b class="text-danger"> {{ $employeeLateIncomes }}</b>, @lang('go_early'):<b class="text-danger"> {{ $employeeGoEarly }}</b>, @lang('actual_working_days'):<b class="text-danger"> {{ $workingAndMissedDays['actual_working_days'] }}</b>-->
    <!--    </td>-->
    <!--</tr>-->

</table>
</body>
</html>
