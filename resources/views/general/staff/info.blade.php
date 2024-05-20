<div class="card-body">
    <ul class="nav nav-pills animation-nav nav-justified gap-2 mb-3" role="tablist">
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#animation-home" role="tab" aria-selected="true">
                @lang('movements')
            </a>
        </li>
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#animation-profile" role="tab" aria-selected="false" tabindex="-1">
                შვებულებები
            </a>
        </li>
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#vacation-days" role="tab" aria-selected="false" tabindex="-1">
                შვებულების დღეები
            </a>
        </li>
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#animation-messages" role="tab" aria-selected="false" tabindex="-1">
                @lang('files')
            </a>
        </li>
{{--        <li class="nav-item waves-effect waves-light" role="presentation">--}}
{{--            <a class="nav-link" data-bs-toggle="tab" href="#animation-settings" role="tab" aria-selected="false" tabindex="-1">--}}
{{--                Settings--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
    <div class="tab-content text-muted">
        <div class="tab-pane active show" id="animation-home" role="tabpanel">
            <div class="d-flex">
                <div class="flex-grow-1 ms-2">
                    <div class="mt-3">
                        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" href="{{ route('users.movements.pdf',$user->id) }}">PDF</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>@lang('day')</th>
                                <th>@lang('start')</th>
                                <th>@lang('finish')</th>
                                <th>@lang('hours_worked')</th>
                            </tr>
                            @foreach($movements as $key => $movement)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $movement->week_day_name ?? '' }}</td>
                                    <td>
                                        @if($movement->checkUser($movement['working_schedule']['week_days']))
                                            <span style="color:green">{{ $movement->formatted_start_date }}</span>
                                        @else
                                            <span style="color:red">{{ $movement->formatted_start_date }}</span>
                                            <br>
{{--                                        @php--}}
{{--                                        $test = \Carbon\Carbon::parse($movement->start_date)->diffInSeconds($movement->checkUserLate($user['working_schedule']['week_days']));--}}
{{--                                        @endphp--}}
{{--                                            დაგვიანება: @if((int)gmdate('H',$test) > 0){{ (int)gmdate('H',$test) }} სთ და @endif{{ (int)gmdate('i',$test) }} წთ--}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($movement->checkUser($movement['working_schedule']['week_days'],true))
                                            <span style="color:green">{{ $movement->formatted_end_date }}</span>
                                        @else
                                            <span style="color:red">{{ $movement->formatted_end_date }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $movement->worked_hours['hours'] }}
                                        @if($movement->worked_hours['hours'] >= 8)
                                            <br><br>ზეგანაკვეთური: {{ $movement->worked_hours['minutes'] }} წთ
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="Banner f16 text-center m-b-15">@lang('workdays'):<b class="text-danger"> {{ $workingAndMissedDays['working_days'] }}</b>, @lang('to_miss'):<b class="text-danger"> {{ $workingAndMissedDays['missed_days'] }}</b>, @lang('late'):<b class="text-danger"> {{ $employeeLateIncomes }}</b>, @lang('go_early'):<b class="text-danger"> {{ $employeeGoEarly }}</b>, @lang('actual_working_days'):<b class="text-danger"> {{ $workingAndMissedDays['actual_working_days'] }}</b>, @lang('at_job'): <b>{{ $totalWorkingTime }}</b></div>
                        <table class="table">
                            <tbody><tr>
                                <td class="text-center bg-success text-white">@lang('work_hours_performed')</td>
{{--                                <td class="table-info text-center Banner">საპატიო მიზეზი</td>--}}
                                <td class="text-center bg-danger text-white">@lang('be_late_leave_early')</td>
                            </tr></tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="animation-profile" role="tabpanel">
            <div class="d-flex">
                <div class="flex-grow-1 ms-2">
                    <div class="col-xl-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">@lang('vacations')</h4>

                            </div><!-- end card header -->

                            <div class="card-body htmlVacationDays">
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="javascript: void(0);" class="avatar-group-item"
                                       style="font-size: 25px; margin-right: 20px" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="@lang('total')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $userVacation }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="avatar-group-item"
                                       style="font-size: 25px; margin-right: 20px" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="@lang('remaining_days')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $userVacation - $usedUserVacations }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="avatar-group-item" style="font-size: 25px"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('days_used')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $usedUserVacations }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->

                    <div class="table-responsive">
                        <table id="user_vacations" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('title')</th>
                                <th scope="col">@lang('date')</th>
                                <th scope="col">@lang('file')</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('title')</th>
                                <th scope="col">@lang('date')</th>
                                <th scope="col">@lang('file')</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

{{--                    <form action="" method="POST" enctype="multipart/form-data" id="form">--}}
{{--                        @csrf--}}
{{--                        <div id="dEdu1" class="m-b-20 mt-3">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="f15 text-info"><strong>@lang('file') <span id="gan">1</span></strong>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6" align="right">--}}
{{--                                    <a href="javascript:void(0)" class="text-success Banner AddEdu" id="1"--}}
{{--                                       style="display: inline;"><i class="fa fa-plus-square-o fa-lg"></i> @lang('add')</a>--}}
{{--                                    &nbsp;--}}
{{--                                    <a href="javascript:void(0)" class="text-danger Banner DelEdu" id="1"--}}
{{--                                       style="display: inline;"><i class="fa fa-trash-o fa-lg"></i> @lang('delete')</a>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="card card-outline-info" style="padding:10px;">--}}
{{--                                <div class="row ">--}}

{{--                                    <div class="col-xxl-6 col-md-6">--}}
{{--                                        <div>--}}
{{--                                            <label for="basiInput" class="form-label">@lang('title')</label>--}}
{{--                                            <input type="text" class="form-control" name="title[]" value="" id="basiInput">--}}
{{--                                            <span class="text-danger errors email_err"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xxl-6 col-md-6">--}}
{{--                                        <div>--}}
{{--                                            <label for="formFile" class="form-label">@lang('file')</label>--}}
{{--                                            <input class="form-control" name="files[]" type="file" id="formFile">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mt-3">--}}
{{--                            <a type="button" class="btn btn-primary waves-effect waves-light upload-file" href="javascript:void(0)">@lang('upload')</a>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </div>
            </div>
        </div>

        <div class="tab-pane" id="vacation-days" role="tabpanel">
            <div class="d-flex">
                <div class="flex-grow-1 ms-2">
                    <div class="col-xl-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">@lang('vacations')</h4>

                            </div><!-- end card header -->

                            <div class="card-body htmlVacationDays">
                                <div class="d-flex justify-content-center mt-3" id="staticRes">
                                    <a href="javascript: void(0);" class="avatar-group-item"
                                       style="font-size: 25px; margin-right: 20px" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="@lang('total')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $userVacation }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="avatar-group-item"
                                       style="font-size: 25px; margin-right: 20px" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="@lang('remaining_days')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $userVacation - $usedUserVacations }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="avatar-group-item" style="font-size: 25px"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('days_used')">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                {{ $usedUserVacations }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->

                    <div class="table-responsive">
                        <table id="user_vacation_days" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">წელი</th>
                                <th scope="col">ჯამში</th>
                                <th scope="col">გამოყენებული</th>
                                <th scope="col">დარჩენილი დღეები</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">წელი</th>
                                <th scope="col">ჯამში</th>
                                <th scope="col">გამოყენებული</th>
                                <th scope="col">დარჩენილი დღეები</th>
                                <th scope="col"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                                        <form action="" method="POST" enctype="multipart/form-data" id="vacation-days-form">
                                            @csrf
                                            <div class="m-b-20 mt-3">
                                                <input type="hidden" class="form-control" name="method" value="" id="method">

                                                <div class="card card-outline-info" style="padding:10px;">
                                                    <div class="row ">

                                                        <div class="col-xxl-6 col-md-6">
                                                            <div>
                                                                <label for="basiInput" class="form-label">@lang('year')</label>
                                                                <select class="form-control" name="year" id="edit_year">
                                                                    @for($year = date('Y')-1; $year <= date('Y'); $year++)
                                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                                    @endfor
                                                                </select>
                                                                <span class="text-danger errors email_err"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6">
                                                            <div>
                                                                <label for="current_quantity" class="form-label">გამოყენებული შვებულებების რაოდენობა</label>
                                                                <input type="text" class="form-control" name="quantity" value="" id="current_quantity">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <a type="button" class="btn btn-primary waves-effect waves-light" id="save-vacation-days" data-id="{{ $user->id }}" href="javascript:void(0)">@lang('save')</a>
                                            </div>
                                        </form>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="animation-messages" role="tabpanel">
            <div class="d-flex">
                <div class="flex-grow-1 ms-2">
                    <div class="table-responsive">
                        <table id="files" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('title')</th>
                                <th scope="col">@lang('date')</th>
                                <th scope="col">@lang('file')</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('title')</th>
                                <th scope="col">@lang('date')</th>
                                <th scope="col">@lang('file')</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" id="form">
                        @csrf
                        <div id="dEdu1" class="m-b-20 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="f15 text-info"><strong>@lang('file') <span id="gan">1</span></strong>
                                    </div>
                                </div>
                                <div class="col-md-6" align="right">
                                    <a href="javascript:void(0)" class="text-success Banner AddEdu" id="1"
                                       style="display: inline;"><i class="fa fa-plus-square-o fa-lg"></i> @lang('add')</a>
                                    &nbsp;
                                    <a href="javascript:void(0)" class="text-danger Banner DelEdu" id="1"
                                       style="display: inline;"><i class="fa fa-trash-o fa-lg"></i> @lang('delete')</a>

                                </div>
                            </div>

                            <div class="card card-outline-info" style="padding:10px;">
                                <div class="row ">

                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">@lang('title')</label>
                                            <input type="text" class="form-control" name="title[]" value="" id="basiInput">
                                            <span class="text-danger errors email_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="formFile" class="form-label">@lang('file')</label>
                                            <input class="form-control" name="files[]" type="file" id="formFile">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a type="button" class="btn btn-primary waves-effect waves-light upload-file" href="javascript:void(0)">@lang('upload')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="animation-settings" role="tabpanel">
            <div class="d-flex mt-2">
                <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-fill text-success"></i>
                </div>
                <div class="flex-grow-1 ms-2">
                    For that very reason, I went on a quest and spoke to many different professional graphic designers and asked them what graphic design tips they live.
                </div>
            </div>
            <div class="d-flex mt-2">
                <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-fill text-success"></i>
                </div>
                <div class="flex-grow-1 ms-2">
                    After gathering lots of different opinions and graphic design basics, I came up with a list of 30 graphic design tips that you can start implementing.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/geokbd.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script>
    $(document).ready(function(){
        $('#tel').inputmask({"mask": "599 99 99 99"});
        $('#name_ka').geokbd();
        $('#surname_ka').geokbd();
    });
</script>
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
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('#vacation-days-form')[0].reset(); // reset form on modals
    });
    $(document.body).on('click', '.upload-file', function(){

        $('.upload-file').html('<i class="fa fa-spin fa-spinner"></i> @lang('wait')');
        $('.upload-file').prop('disabled', true);
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
            url: '{{ route('users.upload.files',$user->id) }}',
            type: 'POST',
            data: formData,
            //async: false,
            success: function (data)
            {
                if (data.status == 1){
                    Swal.fire('@lang('successful')!','@lang('file_uploaded_successfully')','success');
                    reload()
                }
                $('.upload-file').html('ატვირთვა');
                $('.upload-file').prop('disabled', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    $(document).ready(function () {
        flatpickr('.flatpickr-input', {
            locale: '{{ currentLocale() }}'
        });

        files = $('#files').DataTable({
            processing: true,
            order: [ [0, 'desc'] ],
            serverSide: true,
            ajax: {
                url: "{{ route('users.files.ajax',$user->id) }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'formatted_create_date', name: 'formatted_create_date'},
                {data: 'download_file', name: 'download_file'}
            ],
            createdRow: function (row, data, index) {
                $(row).find('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        userVacationDays = $('#user_vacation_days').DataTable({
            processing: true,
            order: [ [0, 'desc'] ],
            serverSide: true,
            ajax: {
                url: "{{ route('users.vacation.quantities.ajax',$user->id) }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'year', name: 'year'},
                {data: 'quantity', name: 'quantity'},
                {data: 'current_quantity', name: 'current_quantity'},
                {data: 'vacation_days', name: 'vacation_days'},
                {data: 'action', name: 'action'},
            ],
            createdRow: function (row, data, index) {
                $(row).find('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        userVacations = $('#user_vacations').DataTable({
            processing: true,
            order: [ [0, 'desc'] ],
            serverSide: true,
            ajax: {
                url: "{{ route('users.vacations.ajax',$user->id) }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'honorable_reason_type', name: 'title'},
                {data: 'honorable_reason_dates', name: 'formatted_create_date'},
                {data: 'download_file', name: 'download_file'}
            ],
            createdRow: function (row, data, index) {
                $(row).find('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    });

    function reload() {
        files.ajax.reload();
        userVacationDays.ajax.reload()
    }

    $(document.body).on('click', '.edit-vacation-days', function () {
        let userId = $(this).data('id');

        $.ajax({
            url: "{{ route('users.change.vacation.days') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                'id': userId,
            },
            success: function (msg) {
                if (msg.status == 0) {
                    $('#method').val('update')
                    $('#current_quantity').val(msg.vacation.current_quantity)
                    $('#edit_year').val(msg.vacation.year)
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

    $(document.body).on('click', '.change-vacation-days-status', function () {
        let id = $(this).data('id');
        let status = $(this).data('status');
        Swal.fire({
            title: 'ნამდვილად გსურთ სტატუსის ცვლილება?',
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
                        url: "{{ route('users.change.vacation.days.status') }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                            'status': status,
                        },
                    })
                        .done(function (response) {
                            if (response.status === 1) {
                                $('.htmlVacationDays').html(response.html)
                                Swal.fire({
                                    title: 'წარმატებული!',
                                    text: "სტატუსი წარმატებით შეიცვალა",
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

    $(document).on('click', '.AddEdu', function () {
        let nid = $(this).attr('id');
        let content = $('#dEdu' + nid).html();
        let newId = parseInt(nid) + 1;
        let newdiv = $("<div id='dEdu" + newId + "' class='m-b-20'>");
        newdiv.html(content);
        newdiv.find(".AddEdu").attr("id", newId);
        newdiv.find(".DelEdu").attr("id", newId);

        newdiv.find("#product_category_" + nid).attr("id", "product_category_" + newId);
        newdiv.find("#product_category_" + nid).attr("for", "product_category_" + newId);
        newdiv.find("#product_detail_" + nid).attr("id", "product_detail_" + newId);
        newdiv.find("#product_detail_" + nid).attr("for", "product_detail_" + newId);
        newdiv.find("#piece_" + nid).attr("id", "piece_" + newId);
        newdiv.find("#piece_" + nid).attr("for", "piece_" + newId);
        newdiv.find("#percent_" + nid).attr("id", "percent_" + newId);
        newdiv.find("#percent_" + nid).attr("for", "percent_" + newId);
        newdiv.find("#unit_price_" + nid).attr("id", "unit_price_" + newId);
        newdiv.find("#unit_price_" + nid).attr("for", "unit_price_" + newId);
        newdiv.find("#total_price_" + nid).attr("id", "total_price_" + newId);
        newdiv.find("#total_price_" + nid).attr("for", "total_price_" + newId);

        newdiv.find("#gan").html(newId);
        newdiv.find("input").val("");

        $('.AddEdu').hide();
        $('.DelEdu').hide();
        $('#dEdu' + nid).after(newdiv);
        $('#percent_' + newId).val($('#percent_1').val())
    });

    $(document).on('click', '.DelEdu', function () {
        var did = $(this).attr('id');
        if (did > 1) {
            $('#dEdu' + did).remove();
            $('.AddEdu').last().show();
            $('.DelEdu').last().show();
        } else {
            Swal.fire('@lang('error')!', '@lang('unable_to_delete')', 'warning');
        }
    });
</script>
