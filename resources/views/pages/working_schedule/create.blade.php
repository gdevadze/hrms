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
                            <h4 class="mb-sm-0">სამუშაო განრიგის დამატება</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">სამუშაო განრიგის დამატება</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row gy-4">
                            <form action="{{ route('working.schedule.store') }}" method="post">
                                @csrf
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">სახელწოდება</label>
                                        <input type="text" class="form-control" name="title" id="basiInput">
                                    </div>
                                </div>
                                @foreach($weekDays as $weekDay)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="week_days[]" value="{{ $weekDay['key'] }}" id="formCheck1">
                                    <label class="form-check-label" for="formCheck1">
                                        {{ $weekDay['title'] }}
                                    </label>
                                    <input type="time" name="start_time[]" class="form-control" id="exampleInputtime">
                                    <input type="time" name="end_time[]" class="form-control" id="exampleInputtime">
                                </div>
                                @endforeach
                                <div class="col-12">
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

@endpush
