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
                            <h4 class="mb-sm-0">@lang('employees')</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('employees')</h4>
                        <div class="flex-shrink-0">
                            <a type="button" class="btn btn-primary waves-effect waves-light" href="{{ route('users.create') }}"><i class="fa fa-plus-square-o"></i> @lang('add')</a>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <strong>პროგრამაზე დაშვება</strong>
                                <select class="form-control" id="role_id">
                                    <option value="">აირჩიეთ</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <strong>პოზიცია</strong>
                                <select class="form-control" id="position_id">
                                    <option selected value="">აირჩიეთ</option>
                                    @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="users" class="table table-striped table-bordered" >
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('full_name')</th>
                                    <th scope="col">@lang('phone')</th>
                                    <th scope="col">@lang('personal_number')</th>
                                    <th scope="col">@lang('company_title_position')</th>
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
                                    <th scope="col">@lang('company_title_position')</th>
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
                    url: "{{ route('users.ajax') }}",
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}'
                        d.role_id = $('#role_id').val()
                        d.position_id = $('#position_id').val()
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'full_name', name: 'name_ka'},
                    {data: 'tel', name: 'tel'},
                    {data: 'personal_num', name: 'personal_num'},
                    {data: 'company_title_position', name: 'company_title_position'},
                    {data: 'action', name: 'action'},
                    {data: 'name_en', name: 'name_en', visible: false},
                    {data: 'surname_ka', name: 'surname_ka', visible: false},
                    {data: 'surname_en', name: 'surname_en', visible: false},
                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

        $('#role_id').on('change', function () {
            table.draw();
        });
        $('#position_id').on('change', function () {
            table.draw();
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

        $(document.body).on('click', '#add_user', function () {
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');
            $.ajax({
                url: "{{ route('users.create.render') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                        $('modal_form_detail').modal('hide');
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

        $(document.body).on('click', '#save-vacation-days', function(){

            {{--$(this).html('<i class="fa fa-spin fa-spinner"></i> @lang('wait')dtd');--}}
            // $(this).prop('disabled', true);
            var form = $('#vacation-days-form')[0];
            var formData = new FormData(form);
            userId = $('#save-vacation-days').data('id');
            let route = "{{ route('users.save.vacation.days', ':id') }}"
            route = route.replace(':id', userId);
            $.ajax({
                url: route,
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    $(this).html('შენახვა');
                    $(this).prop('disabled', false);
                    if (data.status == 1){
                        Swal.fire('@lang('successful')!','შვებულება წარმატებით განახლდა','success');
                        reload()
                    }
                    // console.log($(this).html())
                    $('.htmlVacationDays').html(data.html)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

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
                        Swal.fire('წარმატებული!',response.msg,'success');
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
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

        function reload() {
            table.ajax.reload();
        }

        function deleteUser(id) {
            Swal.fire({
                title: 'ნამდვილად გსურთ მომხმარებლის წაშლა?',
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
                            url: "{{ url('/user/delete_user') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire({
                                        title: 'წარმატებული!',
                                        text: "მომხმარებელი წარმატებით წაიშალა",
                                        icon: 'success',
                                        showCancelButton: false
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload()
                                        }
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
