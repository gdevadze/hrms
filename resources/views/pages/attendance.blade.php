@extends('layouts.app')
@push('css')
    <!--datatable css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">დინამიური გრაფიკის მართვა</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">დინამიური გრაფიკის მართვა</h4>
                        {{--                        <div class="flex-shrink-0">--}}
                        {{--                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_honorable_reason" href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> დამატება</a>--}}
                        {{--                        </div>--}}
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                <tr>

                                    <th scope="col">სახელი, გვარი</th>
                                    @for($i = 1; $i <= $daysInMonth; $i++)
                                    <th scope="col">{{ weekDayName('2024','02',$i) }}<Br>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} თებერ</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $student)
                                <tr>

                                    <td>{{ $student->full_name }}
                                        <input hidden class="user_id_class" data-user-id="{{ $student->id }}">
                                    </td>
                                    @for($i = 1; $i <= $daysInMonth; $i++)
                                        @php
                                            $converted = str_pad($i, 2, '0', STR_PAD_LEFT);
                                        @endphp
                                    <td>

                                        <select style="width: 140px;" class="form-select rounded-pill dynamic_working_schedule" name="dynamic_working_schedule" @if(date('Y-'.$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT)) <= date('Y-m-d')) disabled @endif>
                                            <option selected disabled>აირჩიეთ</option>
                                            @foreach($dynamicWorkingScheduleTime as $dynamicTime)
                                                <option value="{{ $i }}" data-user-id="{{ $student->id }}" data-month-day="{{ $dynamicTime->id }}"
                                                        @if($student->dynamic_working_schedule()->where('date', date('Y-'.$month.'-'.$converted))->first())
                                                            @if($student->dynamic_working_schedule()->where('date', date('Y-'.$month.'-'.$converted))->first()->date == date('Y-'.$month.'-'.$converted))
                                                                @if($student->dynamic_working_schedule()->where('date', date('Y-'.$month.'-'.$converted))->first()->dynamic_working_schedule_time_id == $dynamicTime->id) selected @endif
                                                    @endif

                                                    @endif
                                                >
                                                    {{ $dynamicTime->title }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                    @endfor

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            console.log('sdgds')
            $(".dynamic_working_schedule").change(function() {
                console.log('sdgsdss')
                var selectedOption = $(this).find("option:selected");
                var monthDay = selectedOption.data("month-day");

                // Log the selected day to the console
                console.log("Selected day:", monthDay,$(this).find("option[data-month-day='" + monthDay + "']").val());

                // Clear the selected attribute from all options
                $(this).find("option").removeAttr("selected");

                // Set the selected attribute for the corresponding day option
                $(this).find("option[data-month-day='" + monthDay + "']").prop("selected", true);

                let day = $(this).find("option[data-month-day='" + monthDay + "']").val();
                let user = selectedOption.data('user-id');
                console.log(selectedOption.data('user-id'))
                $.ajax({
                    url: "{{ route('dynamic.working.schedule.update') }}",
                    method: "POST", // Or "GET" depending on your needs
                    data: { schedule_time: monthDay,'month': '{{ $month }}',day: day,user_id:user,'_token': '{{ csrf_token() }}' }, // Sending the selected day as data
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

@endpush


