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
                            <h4 class="mb-sm-0">SMS შეტყობინება</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">SMS შეტყობინება</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row gy-4">
                            <form action="{{ route('messages.send') }}" method="post">
                                @csrf
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="choices-multiple-remove-button" class="form-label">თანამშრომლები</label>
                                        <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="user_ids[]" multiple>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->full_name }} - {{ $user->tel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="exampleFormControlTextarea5" class="form-label">ტექსტი</label>
                                        <textarea class="form-control" name="message_text" required id="exampleFormControlTextarea5" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" type="submit">გაგზავნა</button>
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
