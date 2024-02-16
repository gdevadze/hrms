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
                            <h4 class="mb-sm-0">@lang('reporting_to_work')</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('reporting_to_work')</h4>

                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users" class="table table-striped table-bordered" >
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('day')</th>
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
                                    <th scope="col">@lang('comment')</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('day')</th>
                                    <th scope="col">@lang('date_of_announcement')</th>
                                    <th scope="col">@lang('expiration_date')</th>
                                    <th scope="col">@lang('comment')</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
                    url: "{{ route('user.movements.ajax') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'week_day_name', searchable:false},
                    {data: 'formatted_start_date', name: 'start_date'},
                    {data: 'formatted_end_date', name: 'end_date'},
                    {data: 'formatted_delay_reason', name: 'delay_reason'},
                ],
                createdRow: function (row, data, index) {
                    $(row).find('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

        function reload() {
            table.ajax.reload();
        }

    </script>

    <script>
        $(document.body).on('click', '.save-delay-reason-btn', function () {
            let form = $('#delay_reason').serialize();
            let $this = $(this)
            $this.html('<i class="fa fa-spin fa-spinner"></i> @lang('wait')...');
            $this.prop('disabled', true);
            $.ajax({
                url: $this.data('link'),
                method: "POST",
                data: form,
                success: function (response) {
                    if (response.status == 0) {
                        Swal.fire('{{ __('successful') }}',response.msg,'success');
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
                        $('#modal_form_detail').modal('hide');
                    }else if(response.status == 1){
                        Swal.fire('{{ __('error') }}',response.msg,'warning');
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
    </script>

@endpush
