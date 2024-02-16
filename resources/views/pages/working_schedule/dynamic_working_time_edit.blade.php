@extends('layouts.app')
@push('css')
    <!--datatable css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}"/>
    <!--datatable responsive css-->
    <link rel="stylesheet"
          href="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}"/>

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
                            <h4 class="mb-sm-0">დინამიური გრაფიკის სამუშაო დროის დამატება</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">დინამიური გრაფიკის სამუშაო დროის დამატება</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <form action="{{ route('dynamic.working.schedule.time.update',$dynamicWorkingScheduleTime->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label mb-0">@lang('title')</label>
                                            <input type="text" class="form-control" name="title"
                                                   value="{{ $dynamicWorkingScheduleTime->title }}" required id="basiInput">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label mb-0">შესვენების ხანგრძლივობა</label>
                                            <input type="text" name="break_duration"
                                                   class="form-control"
                                                   value="{{ $dynamicWorkingScheduleTime->break_duration }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label mb-0">@lang('start_time')</label>
                                            <input type="text" name="start_time"
                                                   class="form-control flatpickr-input active"
                                                   value="{{ $dynamicWorkingScheduleTime->start_time }}"
                                                   data-provider="timepickr" data-time-hrs="true" id="timepicker-24hrs"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label mb-0">@lang('end_time')</label>
                                            <input type="text" name="end_time"
                                                   class="form-control flatpickr-input active"
                                                   value="{{ $dynamicWorkingScheduleTime->end_time }}"
                                                   data-provider="timepickr" data-time-hrs="true" id="timepicker-24hrs"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">@lang('save')</button>
                                </div>
                            </form>
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
