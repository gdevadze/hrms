@extends('layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">მთავარი</h4>



                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card crm-widget">
                            <div class="card-body p-0">
                                <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                                    <div class="col">
                                        <div class="py-4 px-3">
                                            <h5 class="text-muted text-uppercase fs-13">თანამშრომლები <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="ri-user-line display-6 text-muted"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $users }}">{{ $users }}</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col">
                                        <div class="mt-3 mt-md-0 py-4 px-3">
                                            <h5 class="text-muted text-uppercase fs-13">დასვენების დღეები <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class=" ri-file-paper-line display-6 text-muted"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $holidays }}">{{ $holidays }}</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
{{--                                    <div class="col">--}}
{{--                                        <div class="mt-3 mt-md-0 py-4 px-3">--}}
{{--                                            <h5 class="text-muted text-uppercase fs-13">Lead Coversation <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>--}}
{{--                                            <div class="d-flex align-items-center">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <i class="ri-pulse-line display-6 text-muted"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="flex-grow-1 ms-3">--}}
{{--                                                    <h2 class="mb-0"><span class="counter-value" data-target="32.89">0</span>%</h2>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div><!-- end col -->--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="mt-3 mt-lg-0 py-4 px-3">--}}
{{--                                            <h5 class="text-muted text-uppercase fs-13">Daily Average Income <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>--}}
{{--                                            <div class="d-flex align-items-center">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <i class="ri-trophy-line display-6 text-muted"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="flex-grow-1 ms-3">--}}
{{--                                                    <h2 class="mb-0">$<span class="counter-value" data-target="1596.5">0</span></h2>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div><!-- end col -->--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="mt-3 mt-lg-0 py-4 px-3">--}}
{{--                                            <h5 class="text-muted text-uppercase fs-13">Annual Deals <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>--}}
{{--                                            <div class="d-flex align-items-center">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <i class="ri-service-line display-6 text-muted"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="flex-grow-1 ms-3">--}}
{{--                                                    <h2 class="mb-0"><span class="counter-value" data-target="2659">0</span></h2>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div><!-- end col -->--}}
                                </div><!-- end row -->
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->




            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
@endsection
