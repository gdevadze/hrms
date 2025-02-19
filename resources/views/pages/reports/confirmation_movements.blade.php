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
                            <h4 class="mb-sm-0">თანამშრომლის ნამუშევარი საათის დადასტურება</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">თანამშრომლის ნამუშევარი საათის დადასტურება</h4>
                        <div class="flex-shrink-0">

                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="confirmation_movements" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>

                                    <th scope="col">@lang('action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>

                                    <th scope="col">@lang('action')</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form_detail" tabindex="-1" role="dialog"
         aria-labelledby="exampleStandardModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">გატარებების ისტორია</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; /* Adjust as needed */
    overflow-y: auto;">
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

    <div class="modal fade" id="import_modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="import_modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="upload_form">
                        @csrf
                        {{--                        <div class="form-group">--}}
                        {{--                            <label>ტიპი</label>--}}
                        {{--                            <select class="form-control" name="type" required>--}}
                        {{--                                <option selected disabled>აირჩიეთ</option>--}}
                        {{--                                <option value="1">დაბეგვრადი ამანათები</option>--}}
                        {{--                                --}}{{----<option value="2">ჩამოსაწერი ამანათები</option>----}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}


                        <label>ფაილი</label>
                        <div class="custom-file mb-3">
                            <input type="file" name="excel_file" class="custom-file-input form-control input-rounded" id="excel_file">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="upload"><i class="fa fa-cloud-upload mr-2" aria-hidden="true"></i> ატვირთვა</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i> დახურვა</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>

    <script>
        let table;
        let save_method;
        $(document).ready(function () {

            table = $('#confirmation_movements').DataTable({
                processing: true,
                order: [[0, 'desc']],
                serverSide: true,
                ajax: {
                    url: "{{ route('reports.confirmation_movements.ajax') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}'
                        d.start_date = $('#fltpcks').val()
                        d.end_date = $('#fltpcks1').val()
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action'},
                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });

            $('#fltpcks').on('change', function () {
                table.draw();
            });
            $('#fltpcks1').on('change', function () {
                table.draw();
            });
        });


        function exportExcel(){
            let startDate = $('#fltpcks').val()
            let endDate = $('#fltpcks1').val()
            if(startDate && endDate){
                let route = "{{ route('reports.movements.export.excel', [':start_date',':end_date']) }}"
                route = route.replace(':start_date', startDate);
                route = route.replace(':end_date', endDate);
                return window.location.href = route
            }else{
                Swal.fire('შეცდომა!','მიუთითეთ ფილტრაციის დეტალები','warning');
            }
        }

        $(document.body).on('click', '.show-detail', function () {
            let id = $(this).data('id');
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');

            $.ajax({
                url: "{{ route('reports.confirmation_movements.render') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': id,
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                        $('#vacation-days-form')[0].reset(); // reset form on modals
                    }else if(msg.status == 2){
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`);
                    }
                    else {
                        $('.htmlDisplay').html('<h3 align=center class=text-danger><i class="fa fa-spin fa-spinner"></i> ამანათზე ინფორმაცია ვერ მოიძებნა!</h3>');
                    }
                },
                error: function () {
                    alert('შეცდომა, გაიმეორეთ მოქმედება.');
                }
            })
        })

        function reload() {
            table.ajax.reload();
        }

    </script>

@endpush
