@extends('layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">@lang('holidays')</h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('holidays')</h4>
                        @can('holiday-create')
                        <div class="flex-shrink-0">
                            <a type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal" href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> @lang('add')</a>
                        </div>
                        @endcan
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="htmlDisplay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" id="add_holiday">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">@lang('add_holiday')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="col-xxl-12 col-md-12">
                            <label for="basiInput" class="form-label">@lang('title')</label>
                            <input type="text" class="form-control" name="title" id="basiInput">
                            <span class="text-danger errors title_err"></span>
                        </div>
                        <div class="col-xxl-12 col-md-12">
                            <label for="basiInput" class="form-label">@lang('date')</label>
                            <input type="text" class="form-control flatpickr-input" name="date" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                            <span class="text-danger errors date_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('close')</button>
                        <button type="button" class="btn btn-primary" id="SaveBtn">@lang('save')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@push('js')
    <script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>

    <script>
        $(document).ready(function () {
            loadHolidays()
            flatpickr('.flatpickr-input', {
                "locale": "ka"
            });
        })

        $(document.body).on('click', '#SaveBtn', function(){
            let $this = $('#SaveBtn');
            let $vBtn = $('#SaveBtn').html();
            $this.html('<i class="fa fa-spin fa-spinner"></i> დაელოდეთ...');
            $this.prop('disabled', true);
            let form = $('#add_holiday').serialize();
            $.ajax({
                url: '{{ route('holidays.store') }}',
                type: 'POST',
                data: form,
                success: function (data){
                    let res=data;
                    if (data.status == 1){
                        Swal.fire('წარმატებული','დასვენების დღე წარმატებით დაემატა','success')
                        loadHolidays()
                    }
                    $this.html($vBtn);
                    $this.prop('disabled', false);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) { // when status code is 422, it's a validation issue
                        $('.errors').html('');
                        $.each(xhr.responseJSON.errors, function (i, error) {
                            $('.'+i+'_err').html(error);
                        });
                    }
                    $this.html($vBtn);
                    $this.prop('disabled', false);
                }
            });
        })

        function loadHolidays(){
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> დაელოდეთ...</h3>');
            $.ajax({
                url: "{{ route('holidays.ajax') }}",
                method: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                    }else if(msg.status == 2){
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`);
                    }
                    else {
                        // setTimeout(function () {
                        $('.htmlDisplay').html('შეკვეთები ვერ მოიძებნა!')
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
