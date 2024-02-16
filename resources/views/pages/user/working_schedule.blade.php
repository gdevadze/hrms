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
                            <h4 class="mb-sm-0">პირადი სამუშაო გრაფიკი</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">პირადი სამუშაო გრაფიკი</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">


                                <div class="table-responsive mt-3">
                                    <table class="table table-hover align-middle table-nowrap table-striped-columns mb-0">
                                        <thead class="table-light">
                                        <tr>

                                            <th scope="col">სამუშაო დღე</th>
                                            <th scope="col">თარიღი</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dynamicWorkingSchedules as $dynamicWorkingSchedule)
                                            <tr>

                                                    <td>
                                                        {{ $dynamicWorkingSchedule->formatted_date }} <br> <br> {{ $dynamicWorkingSchedule->formatted_week_day_name  }}
                                                    </td>
                                                <td>
                                                    @if($dynamicWorkingSchedule->dynamic_working_schedule_time_id == 1)
                                                        დასვენების დღე
                                                    @else
                                                        {{ $dynamicWorkingSchedule->dynamic_working_schedule_time->formatted_start_time }} სთ - {{ $dynamicWorkingSchedule->dynamic_working_schedule_time->formatted_end_time }} სთ
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <!--end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>

@endpush
