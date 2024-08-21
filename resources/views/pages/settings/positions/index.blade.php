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
                            <h4 class="mb-sm-0">პოზიციები</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">პოზიციები</h4>
                        <div class="flex-shrink-0">
                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_position"
                               href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> დამატება</a>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="positions" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>
                                    <th scope="col">მოქმედება</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">დასახელება</th>
                                    <th scope="col">მოქმედება</th>
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

            table = $('#positions').DataTable({
                processing: true,
                order: [[0, 'desc']],
                serverSide: true,
                ajax: {
                    url: "{{ route('settings.positions.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action'},
                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

        $(document.body).on('click', '#add_position', function () {
            $('#modal_title').html('პოზიციის დამატება')
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');
            $.ajax({
                url: "{{ route('settings.positions.create') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                        $('#modal_title').html(msg.title)
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

        $(document.body).on('click', '.edit-position', function () {
            $('#modal_title').html('პოზიციის რედაქტირება')
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('settings.positions.edit') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $(this).data('id'),
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                    }else if(msg.status == 2){
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`);
                    }
                    else {
                        $('.htmlDisplay').html('<h3 align=center class=text-danger><i class="fa fa-spin fa-spinner"></i> შეკვეთაზე ინფორმაცია ვერ მოიძებნა!</h3>');
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

        function deletePosition(id) {
            Swal.fire({
                title: 'ნამდვილად გსურთ პოზიციის წაშლა?',
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
                            url: "{{ route('settings.positions.delete.position') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire('წარმატებული','პოზიცია წარმატებით წაიშალა!','success');
                                    reload();
                                }else if(response.status == 2){
                                    Swal.fire('შეცდომა','პოზიცია მითითებულია თანამშრომლებზე და წაშლა შეუძლებელია','warning');
                                }
                                else {
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
