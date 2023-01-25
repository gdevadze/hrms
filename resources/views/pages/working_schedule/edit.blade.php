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
                            <h4 class="mb-sm-0">სამუშაო განრიგის რედაქტირება</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">სამუშაო განრიგის რედაქტირება</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <form action="{{ route('working.schedule.update',$workingSchedule->id) }}" method="post">
                                @csrf
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="basiInput" class="form-label">სახელწოდება</label>
                                        <input type="text" class="form-control" value="{{ $workingSchedule->title }}" name="title" id="basiInput">
                                    </div>
                                </div>

                                @foreach($resolvedWeekDays as $key => $weekDay)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="week_days[]" @if(isset($weekDay['times'])) checked @endif value="{{ $weekDay['key'] }}" id="formCheck-{{ $key }}">
                                        <label class="form-check-label" for="formCheck-{{ $key }}">
                                            {{ strtoupper($weekDay['title']) }}
                                        </label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label mb-0">დაწყების საათი</label>
                                                    <input type="text" name="start_time[]" class="form-control flatpickr-input active" value="{{ $weekDay['times']['start_time'] ?? '' }}" data-provider="timepickr" data-time-hrs="true" id="timepicker-24hrs" readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label mb-0">დასრულების საათი</label>
                                                    <input type="text" name="end_time[]" class="form-control flatpickr-input active" value="{{ $weekDay['times']['end_time'] ?? '' }}" data-provider="timepickr" data-time-hrs="true" id="timepicker-24hrs" readonly="readonly">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">დამატება</button>
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
