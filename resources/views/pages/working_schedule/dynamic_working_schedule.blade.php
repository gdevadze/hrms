@extends('layouts.app')
@push('css')
    <!--datatable css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

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
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-3">
                                <label for="basiInput" class="form-label">@lang('date_from')</label>
                                <input type="text" class="form-control flatpickr-input" id="fltpcks" name="start_date" readonly="readonly">
                                <span class="text-danger errors start_date_err"></span>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label for="basiInput" class="form-label">@lang('date_to')</label>
                                <input type="text" class="form-control flatpickr-input" id="fltpcks1" name="end_date" readonly="readonly">
                                <span class="text-danger errors start_date_err"></span>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="mb-3">
                                    <label for="company_id" class="form-label text-muted">კომპანია</label>
                                    <select class="form-control" data-choices name="choices-single-default" id="company_id">
                                        <option value="">აირჩიეთ</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->title }} - {{ $company->identification_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="mb-3">
                                    <label for="company_id" class="form-label text-muted">პოზიცია</label>
                                    <select class="form-control" data-choices name="choices-single-default" id="position_id">
                                        <option value="">აირჩიეთ</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="htmlDisplay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
    <script>
        $(document).ready(function() {
            loadDynamicWorkingTable()
            $('#company_id').on('change', function () {
                loadDynamicWorkingTable()
            });
            $('#position_id').on('change', function () {
                loadDynamicWorkingTable()
            });
            $('#fltpcks').on('change', function () {
                loadDynamicWorkingTable()
            });
            $('#fltpcks1').on('change', function () {
                loadDynamicWorkingTable()
            });

            let today = new Date();

            // Initialize Flatpickr with start_date as today
            flatpickr("#fltpcks", {
                defaultDate: today,
                "locale": "ka",
                dateFormat: "Y-m-d"
            });

            // Set end_date to 7 days from today
            let endDate = new Date();
            endDate.setDate(today.getDate() + 7);

            flatpickr("#fltpcks1", {
                defaultDate: endDate,
                "locale": "ka",
                dateFormat: "Y-m-d"
            });
        });

        function loadDynamicWorkingTable(){
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');
            $.ajax({
                url: "{{ route('dynamic.working.schedule.ajax') }}",
                method: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'company_id': $('#company_id').val(),
                    'position_id': $('#position_id').val(),
                    'start_date': $('#fltpcks').val(),
                    'end_date': $('#fltpcks1').val()
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                    }else if(msg.status == 2){
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`);
                    }
                    else {
                        // setTimeout(function () {
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`)
                        // }, 1000);
                        // Swal.fire('შეცდომა!','მომხმარებელი ვერ მოიძებნა','warning');
                    }
                },
                error: function () {
                    alert('შეცდომა, გაიმეორეთ მოქმედება.');
                }
            })
        }

        $(document.body).on('click', '.save-btn', function () {
            let form = $('#set_time_user').serializeArray();
            form.push({name: "company_id", value: $('#company_id').val()});
            form.push({name: "position_id", value: $('#position_id').val()});
            let $this = $(this)
            $this.html('<i class="fa fa-spin fa-spinner"></i> დაელოდეთ...');
            $this.prop('disabled', true);
            $.ajax({
                url: $this.data('link'),
                method: "POST",
                data: form,
                success: function (response) {
                    if (response.status == 0) {
                        Swal.fire('წარმატებული!',response.msg,'success');
                        $('#dateModal').modal('hide');
                        loadDynamicWorkingTable()
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) { // when status code is 422, it's a validation issue
                        $('.errors').html('');
                        $.each(xhr.responseJSON.errors, function (i, error) {
                            $('.'+i+'_err').html(error);
                        });
                    }
                    $this.html('შენახვა');
                    $this.prop('disabled', false);
                }
            })
        })
    </script>

@endpush
