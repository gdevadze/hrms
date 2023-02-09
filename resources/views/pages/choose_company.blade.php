@extends('layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">კომპანია</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="row gallery-wrapper">
                                        @foreach($companies as $company)
                                            <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development">
                                                <div class="gallery-box card">
                                                    <div class="gallery-container">
                                                        <a class="image-popup" href="{{ route('set.company',$company->id) }}" title="">
                                                            <img class="gallery-img img-fluid mx-auto" width="210" style="display: block;margin-left: auto;margin-right: auto;" src="{{ ($company->img) ? $company->formatted_img : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.svg.png' }}" alt="" />
                                                            <div class="gallery-overlay">
                                                                <h5 class="overlay-caption">{{ $company->title }}</h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- end col -->

                                        <!-- end col -->
{{--                                        <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing" data-category="project designing">--}}
{{--                                            <div class="gallery-box card">--}}
{{--                                                <div class="gallery-container">--}}
{{--                                                    <a class="image-popup" href="assets/images/small/img-4.jpg" title="">--}}
{{--                                                        <img class="gallery-img img-fluid mx-auto" src="assets/images/small/img-4.jpg" alt="" />--}}
{{--                                                        <div class="gallery-overlay">--}}
{{--                                                            <h5 class="overlay-caption">Drawing a sketch</h5>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}

{{--                                                </div>--}}

{{--                                                <div class="box-content">--}}
{{--                                                    <div class="d-flex align-items-center mt-1">--}}
{{--                                                        <div class="flex-grow-1 text-muted">by <a href="#" class="text-body text-truncate">Jason McQuaid</a></div>--}}
{{--                                                        <div class="flex-shrink-0">--}}
{{--                                                            <div class="d-flex gap-3">--}}
{{--                                                                <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">--}}
{{--                                                                    <i class="ri-thumb-up-fill text-muted align-bottom me-1"></i> 825--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">--}}
{{--                                                                    <i class="ri-question-answer-fill text-muted align-bottom me-1"></i> 101--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- ene card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
