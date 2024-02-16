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
                            <h4 class="mb-sm-0">დაქვემდებარებული თანამშრომლების სია</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">დაქვემდებარებული თანამშრომლების სია</h4>
                        {{--                        <div class="flex-shrink-0">--}}
                        {{--                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_user" href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> @lang('add')</a>--}}
                        {{--                        </div>--}}
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users" class="table table-striped table-bordered" >
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('full_name')</th>
                                    <th scope="col">@lang('phone')</th>
                                    <th scope="col">@lang('personal_number')</th>
                                    <th scope="col">@lang('action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('full_name')</th>
                                    <th scope="col">@lang('phone')</th>
                                    <th scope="col">@lang('personal_number')</th>
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
                    <h5 class="modal-title" id="modal_title">@lang('user_information')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="htmlDisplay"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                            class="fa fa-times mr-2"
                            aria-hidden="true"></i> @lang('close')
                    </button>
                </div>

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

    <script>
        let table;
        let save_method;
        $(document).ready(function () {

            table = $('#users').DataTable({
                processing: true,
                order: [ [0, 'desc'] ],
                serverSide: true,
                ajax: {
                    url: "{{ route('users.subordinates.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'tel', name: 'tel'},
                    {data: 'personal_num', name: 'email'},
                    {data: 'action', name: 'action'},

                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

        $(document.body).on('click', '.change-password', function () {
            let userId = $(this).data('id');
            Swal.fire({
                title: 'ნამდვილად გსურთ მომხმარებლზე პაროლის შეცვლა?',
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
                            url: "{{ route('users.reset.password') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': userId
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire({
                                        title: 'წარმატებული!',
                                        text: "პაროლი წარმატებით შეიცვალა, ახალი პაროლი: "+response.password,
                                        icon: 'success',
                                        showCancelButton: false
                                    }).then((result) => {
                                        reload()
                                    })
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
        })

        $(document.body).on('click', '.staff_info', function () {
            let userId = $(this).data('id');
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');

            $.ajax({
                url: "{{ route('staff_info.info') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'user_id': userId,
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

        function reload() {
            table.ajax.reload();
        }
    </script>

@endpush
