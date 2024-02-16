<div class="table-responsive">
    <table class="table table-hover align-middle table-nowrap table-striped-columns mb-0">
        <thead class="table-light">
        <tr>

            <th scope="col">სახელი, გვარი</th>
            @for($i = 1; $i <= $daysInMonth; $i++)

                <th scope="col">{{ weekDayName($year,$month,$i) }}
                    <Br>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} {{ $monthName }}</th>
{{--                @if(weekDayName($year,$month,$i) == 'კვირა')--}}
{{--                    <th scope="col">კვირის განაკვეთი /<Br> ჯამური დრო</th>--}}
{{--                @endif--}}
            @endfor
        </tr>
        </thead>
        <tbody>
        @php
        $totalWorkingHours = 0;
        @endphp
        @foreach($users as $student)

            <tr>

                <td>{{ $student->user->full_name }}
                    <input hidden class="user_id_class" data-user-id="{{ $student->id }}">
                </td>
                @for($i = 1; $i <= $daysInMonth; $i++)

                    @php
                        $converted = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $date = \Carbon\Carbon::createFromFormat("Y-m-d", "{$year}-{$month}-{$converted}");
                        $hours = 0;
                    @endphp
                    <td>
                        @if($student->dynamic_working_schedule()->where('date', date($year.'-'.$month.'-'.$converted))->first())

                            @php
                                $dy = $student->dynamic_working_schedule()->where('date', date($year.'-'.$month.'-'.$converted))->first();
                                $time = \App\Models\DynamicWorkingScheduleTime::findOrFail($dy->dynamic_working_schedule_time_id);
                                $workedSeconds = \Carbon\Carbon::parse($time->start_time)->addMinutes($time->break_duration)->diffInSeconds($time->end_time);
                                $hours += $workedHours = (int)($workedSeconds / 3600);
                                $totalWorkingHours += $hours;
                            @endphp

                        @endif
{{--                        @if(!$date->isSunday())--}}
                            <select style="width: 160px;" class="form-select rounded-pill dynamic_working_schedule"
                                    name="dynamic_working_schedule">
                                <option selected disabled>აირჩიეთ</option>
                                @foreach($dynamicWorkingScheduleTime as $dynamicTime)

                                    <option value="{{ $i }}" data-user-id="{{ $student->user_id }}"
                                            data-month-day="{{ $dynamicTime->id }}"
                                            @if($student->dynamic_working_schedule()->where('date', date($year.'-'.$month.'-'.$converted))->first())
                                                @if($student->dynamic_working_schedule()->where('date', date($year.'-'.$month.'-'.$converted))->first()->date == date($year.'-'.$month.'-'.$converted))
                                                    @if($student->dynamic_working_schedule()->where('date', date($year.'-'.$month.'-'.$converted))->first()->dynamic_working_schedule_time_id == $dynamicTime->id) selected @endif
                                        @endif
                                        @endif
                                    >
                                        {{ $dynamicTime->title }}
                                    </option>
                                @endforeach
                            </select>
{{--                        @else--}}
{{--                        {{ $totalWorkingHours }}--}}
{{--                        @endif--}}
                    </td>

                @endfor

            </tr>

        @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(".dynamic_working_schedule").change(function () {
            let selectedOption = $(this).find("option:selected");
            let monthDay = selectedOption.data("month-day");

            // Clear the selected attribute from all options
            $(this).find("option").removeAttr("selected");

            // Set the selected attribute for the corresponding day option
            $(this).find("option[data-month-day='" + monthDay + "']").prop("selected", true);

            let day = $(this).find("option[data-month-day='" + monthDay + "']").val();
            let user = selectedOption.data('user-id');
            $.ajax({
                url: "{{ route('dynamic.working.schedule.update') }}",
                method: "POST", // Or "GET" depending on your needs
                data: {
                    schedule_time: monthDay,
                    'month': '{{ $month }}',
                    'year': '{{ $year }}',
                    day: day,
                    user_id: user,
                    '_token': '{{ csrf_token() }}' }, // Sending the selected day as data
                success: function(response) {
                    // Handle the AJAX response here
                    console.log("AJAX response:", response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        });
    });
</script>
