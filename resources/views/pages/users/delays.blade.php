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
                            <h4 class="mb-sm-0">დაგვიანების მიზეზები</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">დაგვიანების მიზეზები</h4>
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
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
                                    <th scope="col">დაგვიანება</th>
                                    <th scope="col">მიზეზი</th>
{{--                                    <th scope="col">@lang('action')</th>--}}
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('full_name')</th>
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
                                    <th scope="col">დაგვიანება</th>
                                    <th scope="col">მიზეზი</th>
{{--                                    <th scope="col">@lang('action')</th>--}}
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
                    url: "{{ route('users.delays.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_full_name', name: 'full_name'},
                    {data: 'formatted_start_date', name: 'tel'},
                    {data: 'formatted_end_date', name: 'email'},
                    {data: 'formatted_late', name: 'formatted_late'},
                    {data: 'delay_reason', name: 'delay_reason'},
                    // {data: 'action', name: 'action'}
                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

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
    </script>

@endpush
