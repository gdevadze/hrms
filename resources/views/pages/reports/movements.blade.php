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
                            <h4 class="mb-sm-0">თანამშრომლის მოძრაობის რეპორტი</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">თანამშრომლის მოძრაობის რეპორტი</h4>
                        <div class="flex-shrink-0">
                            <a type="button" class="btn btn-primary waves-effect waves-light" href="javascript:void(0)" onclick="importExcel()"><i class="fa fa-file-excel-o"></i> Excel Import</a>
                            <a type="button" class="btn btn-primary waves-effect waves-light" href="{{ route('reports.movements.create') }}"><i class="fa fa-plus-square-o"></i> @lang('add')</a>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-lg-6 col-md-6">
                                <label for="basiInput" class="form-label">@lang('date_from')</label>
                                <input type="text" class="form-control flatpickr-input" id="fltpcks" name="start_date" readonly="readonly">
                                <span class="text-danger errors start_date_err"></span>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label for="basiInput" class="form-label">@lang('date_to')</label>
                                <input type="text" class="form-control flatpickr-input" id="fltpcks1" name="end_date" readonly="readonly">
                                <span class="text-danger errors start_date_err"></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-soft-secondary waves-effect waves-light mb-3" onclick="exportExcel()"><i class="ri-file-excel-line"></i></a> Excel</button>
                        <div class="table-responsive">
                            <table id="positions" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
                                    <th scope="col">@lang('action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
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
            flatpickr("#fltpcks", {
                "locale": "ka",
                dateFormat: "Y-m-d"
            });
            flatpickr("#fltpcks1", {
                "locale": "ka",
                dateFormat: "Y-m-d"
            });
            table = $('#positions').DataTable({
                processing: true,
                order: [[0, 'desc']],
                serverSide: true,
                ajax: {
                    url: "{{ route('reports.movements.ajax') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}'
                        d.start_date = $('#fltpcks').val()
                        d.end_date = $('#fltpcks1').val()
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user.full_name', name: 'user.name_ka'},
                    {data: 'formatted_start_date', name: 'start_date'},
                    {data: 'formatted_end_date', name: 'end_date'},
                    {data: 'action', name: 'action'},
                    {data: 'user.name_en', name: 'user.name_en', visible: false},
                    {data: 'user.surname_ka', name: 'user.surname_ka', visible: false},
                    {data: 'user.surname_en', name: 'user.surname_en', visible: false},
                    {data: 'user.personal_num', name: 'user.personal_num', visible: false},
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

        $('#upload_form').on('submit', function(e){
            var input, file;
            input = document.getElementById('excel_file');
            file = input.files[0];
            e.preventDefault();
            if(input.value == ''){
                Swal.fire('შეცდომა!','გთხოვთ აირჩიოთ ფაილი','warning');
                return
            }
            let exts = ["csv","xlsx"];
            let ext = input.files[0].name.split('.').pop().toLowerCase();
            if (!(exts.indexOf(ext)>=0)) {
                Swal.fire("მოქმედება არ შესრულდა!", `არათავსებადი ${ext} ტიპის ფაილი`, "warning");
            } else if(file.size >= 5 * 1024 * 1024){
                Swal.fire('ფაილი ვერ აიტვირთა','მაქსიმალური ფაილის ზომაა 5 MB','warning')
            }else{
                $('#upload').html('<i class="fa fa-spinner fa-spin mr-1"></i>დაელოდეთ...');
                $('#upload').attr('disabled',true);
                $.ajax({
                    url:"{{ route('reports.movements.import.movements.excel') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(data){
                        reload();
                        if (data.status == 1) {
                            $('#import_modal_form').modal('hide');
                            Swal.fire('ფაილი აიტვირთა','თქვენი ფაილი წარმატებით აიტვირთა','success')
                        }else if (data.status == 0){
                            Swal.fire('ფაილი ვერ აიტვირთა','გადაამოწმეთ ფაილის სიზუსტე','error')
                        }
                        $('#upload').html('<i class="fa fa-floppy-o mr-1" aria-hidden="true"></i>ატვირთვა');
                        $('#upload').attr('disabled',false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire('ფაილი ვერ აიტვირთა','სცადეთ თავიდან','error')
                        $('#upload').html('<i class="fa fa-floppy-o mr-1" aria-hidden="true"></i>ატვირთვა');
                        $('#upload').attr('disabled',false);
                    }
                });
            }
        });

        function importExcel() {
            $('#upload_form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#import_modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('#import_modal_title').text(`დაბეგვრადი ამანათების იმპორტი`);
        }

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

        $(document.body).on('click', '.movement-edit', function () {
            let id = $(this).data('id');
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');

            $.ajax({
                url: "{{ route('reports.movements.edit.render') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': id,
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
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

        $(document.body).on('click', '.save-btn', function () {
            let form = $('#user_info').serialize();
            let $this = $(this)
            console.log($this.data('link'))
            $this.html('<i class="fa fa-spin fa-spinner"></i> დაელოდეთ...');
            $this.prop('disabled', true);
            $.ajax({
                url: $this.data('link'),
                method: "POST",
                data: form,
                success: function (response) {
                    if (response.status == 0) {
                        Swal.fire('წარმატებული!', response.msg, 'success');
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) { // when status code is 422, it's a validation issue
                        $('.errors').html('');
                        $.each(xhr.responseJSON.errors, function (i, error) {
                            $('.' + i + '_err').html(error);
                        });
                    }
                    $this.html('შენახვა');
                    $this.prop('disabled', false);
                }
            })
        })

        function reload() {
            table.ajax.reload();
        }

    </script>

@endpush
