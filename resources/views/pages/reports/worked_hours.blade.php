@extends('layouts.app')
@push('css')
    <!--datatable css-->
    <link rel="stylesheet" href="{{ asset('assets/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}"/>
    <!--datatable responsive css-->
    <link rel="stylesheet"
          href="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}"/>

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
                            <h4 class="mb-sm-0">თანამშრომლის ნამუშევარი საათის რეპორტი</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">თანამშრომლის ნამუშევარი საათის რეპორტი</h4>
                        {{--                        <div class="flex-shrink-0">--}}
                        {{--                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_position"--}}
                        {{--                               href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> დამატება</a>--}}
                        {{--                        </div>--}}
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xxl-6 col-md-6">
                                <label for="basiInput" class="form-label">@lang('date')</label>
                                <input type="text" class="form-control flatpickr-input" id="fltpcks" name="start_date" readonly="readonly">
                                <span class="text-danger errors start_date_err"></span>
                            </div>
                            <div class="col-lg-6 col-md-12">
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

                        </div>
                        <div class="htmlDisplay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form_detail" tabindex="-1" role="dialog"
         aria-labelledby="exampleStandardModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="htmlDisplay"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                            class="fa fa-times mr-2"
                            aria-hidden="true"></i> დახურვა
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script>
        $(document).ready(function () {
            loadHrTable()
            $('#company_id').on('change', function () {
                loadHrTable()
            });
            $('#fltpcks').on('change', function () {
                loadHrTable()
            });
            flatpickr('#fltpcks',{
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true, //defaults to false
                        dateFormat: "m.Y", //defaults to "F Y"
                        altFormat: "F Y", //defaults to "F Y"
                    })
                ]
            });
        })

        function exportExcel(){
            let companyId = $('#company_id').val()
            let selectedDate = $('#fltpcks').val()
            console.log(companyId,selectedDate)
            if(companyId){
                let route = "{{ route('reports.worked.hours.export.excel', [':id',':selectedDate',':type']) }}"
                route = route.replace(':id', companyId);
                route = route.replace(':selectedDate', selectedDate);
                route = route.replace(':type', '{{ $type }}');
                return window.location.href = route
            }else{
                Swal.fire('შეცდომა!','მიუთითეთ ფილტრაციის დეტალები','warning');
            }
        }

        function loadHrTable(){
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');
            $.ajax({
                url: "{{ route('reports.worked.hours.ajax') }}",
                method: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'type': '{{ $type }}',
                    'company_id': $('#company_id').val(),
                    'selected_date': $('#fltpcks').val()
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
    </script>

@endpush
