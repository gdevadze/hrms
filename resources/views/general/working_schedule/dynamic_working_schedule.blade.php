<style>
    tr>th:first-child,tr>td:first-child {
        position: sticky;
        left: 0;
    }
</style>
<div class="table-responsive">
<table class="table  align-middle table-nowrap table-striped-columns mb-0">
    @php
        // Create a collection of all dates in the range
        $dateRange = collect();
        $currentDate = $start->copy();

        while ($currentDate->lte($end)) {
            $dateRange->push($currentDate->copy());
            $currentDate->addDay();
        }
    @endphp
    <thead class="table-light">
    <tr>
        <th scope="col">სახელი, გვარი</th>
        @foreach ($dateRange as $date)
            <th scope="col" class="date-clickable" data-date="{{ $date->format('Y-m-d') }}">{{ weekDayName($date->year, $date->month, $date->day) }}<br>{{ $date->translatedFormat('d M') }}</th>
            @if(weekDayName($date->year, $date->month, $date->day) == 'კვირა')
                <th scope="col">ჯამური დრო</th>
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php
        $totalWorkingHours = 0;
    @endphp
    @foreach ($users as $student)
        <tr>
            <td style="background-color: white;">{{ $student->user->full_name }}<input hidden class="user_id_class" data-user-id="{{ $student->id }}"></td>
            @foreach ($dateRange as $date)
                @php
                    $dy = $student->dynamic_working_schedule->firstWhere('date', $date->format('Y-m-d'));
                    $hours = 0;
                @endphp

                <td>
                    @if ($dy && $dy->dynamicWorkingScheduleTime)
                        @php
                            $time = $dy->dynamicWorkingScheduleTime;
                            $workedSeconds = \Carbon\Carbon::parse($time->start_time)->addMinutes($time->break_duration)->diffInSeconds($time->end_time);
                            $hours = (int)($workedSeconds / 3600);
                            $totalWorkingHours += $hours;
                        @endphp
                    @endif
                    <select style="width: 160px;" class="form-select rounded-pill dynamic_working_schedule" name="dynamic_working_schedule">
                        <option selected disabled>აირჩიეთ</option>
                        @foreach ($dynamicWorkingScheduleTime as $dynamicTime)
                            <option value="{{ $date->format('d') }}" data-month="{{ $date->format('m') }}" data-year="{{ $date->format('Y') }}" data-user-id="{{ $student->user_id }}" data-month-day="{{ $dynamicTime->id }}" {{ optional($dy)->dynamic_working_schedule_time_id == $dynamicTime->id ? 'selected' : '' }}>{{ $dynamicTime->title }}</option>
                        @endforeach
                    </select>
                </td>
                @if($date->isSunday())
                    <th>{{ $student->dynamic_working_schedule->whereBetween('date', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->sum('workedHours') ?? '' }} / 40</th>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">@lang('user_information')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="htmlDisplayTimeList"></div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                        class="fa fa-times mr-2"
                        aria-hidden="true"></i> @lang('close')
                </button>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $(".date-clickable").click(function () {
            $('#dateModal').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplayTimeList").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');
            $.ajax({
                url: "{{ route('dynamic.working.schedule.time.list.render') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'date': $(this).data('date'),
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplayTimeList').html(msg.html);
                        // $('modal_form_detail').modal('hide');
                        // loadDynamicWorkingTable()
                    }
                },
                error: function () {
                    alert('შეცდომა, გაიმეორეთ მოქმედება.');
                }
            })
        });

        $(".dynamic_working_schedule").change(function () {
            let selectedOption = $(this).find("option:selected");
            let monthDay = selectedOption.data("month-day");
            let month = selectedOption.data("month");
            let year = selectedOption.data("year");

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
                    'month': month,
                    'year': year,
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
