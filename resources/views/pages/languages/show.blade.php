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
                            <h4 class="mb-sm-0">თარგმანი</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">თარგმანი</h4>
                        {{--                        <div class="flex-shrink-0">--}}
                        {{--                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_honorable_reason" href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> დამატება</a>--}}
                        {{--                        </div>--}}
                    </div><!-- end card header -->
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif
                        <button type="submit" id="add_key"
                                data-id="{{ $language->id }}"
                                class="btn btn-outline-primary waves-effect waves-light mb-2">
                            დამატება
                        </button>
                        <table id="lang_json" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th scope="col">Key</th>
                                <th scope="col">თარგმანი</th>
                                <th scope="col">მოქმედება</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="col">Key</th>
                                <th scope="col">თარგმანი</th>
                                <th scope="col">მოქმედება</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modal_form" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="htmlDisplay"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">დახურვა</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@push('js')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>

    <script>
        let table;
        $(document).ready(function () {

            table = $('#lang_json').DataTable({
                processing: true,
                order: [[0, 'desc']],
                serverSide: true,
                language: {
                    url: "{{ __('table-language') }}"
                },
                ajax: {
                    url: "{{ route('languages.show.ajax') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}'
                        d.id = '{{ $language->code }}'
                    }
                },
                columns: [
                    {data: 'key', name: 'key'},
                    {data: 'value', name: 'value'},
                    {data: 'action', name: 'action'},
                ],
                createdRow: function (row, data, index) {
                    if(data.value == ''){
                        $(row).attr("style", "background: #f9e6ed;cursor: pointer!important;")
                    }
                    @if($language->code != 'ka')
                    if (isGeorgianText(data.value)) {
                        $(row).attr("style", "background: #f9e6ed;cursor: pointer!important;")
                    }
                    @endif
                }
            });
            $.fn.dataTable.ext.errMode = 'none';
        });

        function isGeorgianText(text) {
            // Regular expression pattern for Georgian characters
            var pattern = /^[\u10A0-\u10FF\u1C90-\u1CBF\u2D00-\u2D25\u2D27\u2D2D\s]+$/u;

            // Test if the text matches the pattern
            return pattern.test(text);
        }

        function reload() {
            table.ajax.reload();
        }

        $(document.body).on('click', '#add_key', function () {
            $('#modal_label').html('დამატება')
            $('#modal_form').modal('show');
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');
            $.ajax({
                url: "{{ route('languages.create.language.json') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': $(this).data('id')
                },
                success: function (msg) {
                    $('.htmlDisplay').html(msg.html);
                },
                error: function () {
                    alert('შეცდომა, გაიმეორეთ მოქმედება.');
                }
            })
        })

        $(document.body).on('click', '#edit_key', function () {
            let id = $(this).data('id');
            let key = $(this).data('key');
            let value = $(this).data('value');
            console.log(key,value)
            $('#modal_label').html('რედაქტირება')
            $('#modal_form').modal('show');
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');

            $.ajax({
                url: "{{ route('languages.edit.language.json') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': id,
                    'key': key,
                    'value': value,
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
            let form = $('#language_json_form').serialize();
            let $this = $(this)
            console.log($this)
            $this.html('<i class="fa fa-spin fa-spinner"></i> დაელოდეთ...');
            $this.prop('disabled', true);
            $.ajax({
                url: $this.data('link'),
                method: "POST",
                data: form,
                success: function (response) {
                    if (response.status == 0) {
                        Swal.fire('წარმატებული!',response.msg,'success')
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
                        $('#modal_form').modal('hide')
                    }else if(response.status == 1){
                        Swal.fire('შეცდომა!',response.msg,'warning');
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
                        $('#modal_form').modal('hide')
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



        function deleteLangJson() {
            let id = $('#lang_data').data('id');
            let key = $('#lang_data').data('key');
            let value = $('#lang_data').data('value');
            console.log(id)
            Swal.fire({
                title: 'ნამდვილად გსურთ key-ის წაშლა?',
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'დიახ!',
                cancelButtonText: 'არა!',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $('.swal2-confirm').html('<i class="fa fa-spinner fa-spin mr-1"></i>');
                        $.ajax({
                            url: "{{ route('languages.delete.language.json') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id,
                                'key': key,
                                'value': value
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire('წარმატებული',`${key} წარმატებით წაიშალა`,'success')
                                    reload()
                                } else {
                                    Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                                }
                            })
                            .fail(function () {
                                Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                            });
                    });
                },
                allowOutsideClick: true
            });
        }

        function statusAction(id,status) {
            let title = '';
            if (status == 1){
                title = 'ნამდვილად გსურთ მომხმარებლის აქტიურად მონიშნვნა?';
            }else{
                title = 'ნამდვილად გსურთ მომხმარებლის არა აქტიურად მონიშვნა?';
            }
            Swal.fire({
                title: title,
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'დიახ!',
                cancelButtonText: 'არა!',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $('.swal2-confirm').html('<i class="fa fa-spinner fa-spin mr-1"></i>');
                        $.ajax({
                            url: "{{ url('/staff_info.blade/status_action') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id,
                                'status': status
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire('წარმატებული!','სტატუსი წარმატებით განახლდა!','success')
                                    reload()
                                } else {
                                    Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                                }
                            })
                            .fail(function () {
                                Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                            });
                    });
                },
                allowOutsideClick: true
            });
        }
    </script>

@endpush
