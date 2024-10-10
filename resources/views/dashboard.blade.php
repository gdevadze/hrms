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
                            <h4 class="mb-sm-0">@lang('home')</h4>


                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if(!currentUser()->hasRole('User'))
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card crm-widget">

                                <div class="card-body p-0">
                                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                                        @can('user-list')
                                        <div class="col">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">@lang('employees') <i
                                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-user-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value"
                                                                               data-target="{{ $users }}">{{ $users }}</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        @endcan
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">@lang('holidays') <i
                                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i>
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class=" ri-file-paper-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value"
                                                                               data-target="{{ $holidays }}">{{ $holidays }}</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                @endif
                @if(currentUser()->id == 1)
                                <a href="javascript:void(0)" onclick="exportData()">დატა</a>

                                <script>
                                    function exportData() {
                                        $.ajax({
                                            url: '{{ route('settings.readers.import.data') }}',
                                            type:"get",
                                            data: {
                                            },
                                            success: function(data)
                                            {
                                                console.log(data)
                                                if(data.status == 0){
                                                    Swal.fire('წარმატებული','ინფორმაცია წარმატებით განახლდა!','success')
                                                }else{
                                                    Swal.fire('შეცდომა','ვერ ხერხდება რიდერთან დაკავშირება','warning')
                                                }

                                                // $('#user_day_money').html(data.money.toFixed(2))
                                                //window.setTimeout(update, 1000);
                                            }
                                        });
                                    }
                                </script>
                @endif
                <div class="row">
                    @if(currentUser()->working_schedule_id)
                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">@lang('work_accounting'): {{ $currentDayName }}, {{ date('d.m.Y') }}</h4>

                            </div><!-- end card header -->

                            <div class="card-body">
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mb-xl-0" role="alert">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            @if(in_array(getIp(), $ipCollection))
                                @isset($todayMovement)
                                    <p>@lang('revelation_time')
                                        : {{ $todayMovement->formatted_start_date }} @isset($todayMovement->end_date)
                                            - {{ $todayMovement->formatted_end_date }}
                                        @endisset</p>
                                @else
                                    <p>@lang('fix_it')</p>
                                @endisset
                                <p>@lang('start_end_work_button')</p>
                                    @isset($todayMovement)
                                        @if(!$todayMovement->end_date && \Carbon\Carbon::parse($todayMovement->start_date)->diffInMinutes(\Carbon\Carbon::now()) > 5)
                                            <a class="btn btn-outline-danger waves-effect waves-light"
                                               href="{{ route('user.movement.action') }}">@lang('completion_of_work') <i
                                                    class="ri-arrow-right-line"></i></a>
                                        @endif
                                    @else
                                        <a class="btn btn-outline-success waves-effect waves-light"
                                           href="{{ route('user.movement.action') }}">@lang('start_work') <i
                                                class="ri-arrow-right-line"></i></a>
                                    @endisset
                                @else
                                    <div style="text-align: center;font-size: 17px">
                                        <p>თქვენ არ იმყოფებით აღრიცხვის ოფისში</p>
                                        <p> თქვენი IP მისამართია: <a
                                                href="javascript:void(0)" onclick="copyUserIp()" ><span id="user_ip">{{ \request()->ip() }}</span> <span  id="btn_room_num"><i class="ri-file-copy-line"></i></span></a></p>
                                    </div>
                                @endif
                            </div>

                        </div> <!-- .card-->
                    </div> <!-- .col-->
                    @endif
                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">@lang('my_vacations')</h4>

                            </div><!-- end card header -->

                            <div class="card-body">
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
                    @if(count($birthdays) > 0)
                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="ri-cake-2-line"></i> იუბილარები</h4>

                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <div data-simplebar="init" style="max-height: 365px;">
                                        <div class="simplebar-wrapper" style="margin: 0px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                         aria-label="scrollable content"
                                                         style="height: auto; overflow: hidden scroll;">
                                                        <div class="simplebar-content" style="padding: 0px;">
                                                            <ul class="list-group list-group-flush">
                                                                @foreach($birthdays as $birthday)
                                                                    <li class="list-group-item list-group-item-action">
                                                                        <div class="d-flex align-items-center">
                                                                            <img
                                                                                src="assets/images/users/user-dummy-img.jpg"
                                                                                alt=""
                                                                                class="avatar-xs object-cover rounded-circle">
                                                                            <div class="ms-3 flex-grow-1">
                                                                                <a href="#!" class="stretched-link">
                                                                                    <h6 class="fs-14 mb-1">{{ $birthday->full_name }}</h6>
                                                                                </a>
                                                                                {{--                                                                            <p class="mb-0 text-muted"></p>--}}
                                                                            </div>
                                                                            <div>
                                                                                <h6>{{ birthdateDay($birthday->birthdate) }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder"
                                                 style="width: auto; height: 200px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                            <div class="simplebar-scrollbar"
                                                 style="height: 299px; transform: translate3d(0px, 65px, 0px); display: block;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                    @endif
                    @if(count($expireContracts))
                        <div class="col-xl-4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">ხელშეკრულებები</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <div data-simplebar="init" style="max-height: 365px;">
                                            <div class="simplebar-wrapper" style="margin: 0px;">
                                                <div class="simplebar-height-auto-observer-wrapper">
                                                    <div class="simplebar-height-auto-observer"></div>
                                                </div>
                                                <div class="simplebar-mask">
                                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                             aria-label="scrollable content"
                                                             style="height: auto; overflow: hidden scroll;">
                                                            <div class="simplebar-content" style="padding: 0px;">
                                                                <ul class="list-group list-group-flush">
                                                                    @foreach($expireContracts as $expireContract)
                                                                        <li class="list-group-item list-group-item-action">
                                                                            <div class="d-flex align-items-center">
                                                                                <img
                                                                                    src="assets/images/users/user-dummy-img.jpg"
                                                                                    alt=""
                                                                                    class="avatar-xs object-cover rounded-circle">
                                                                                <div class="ms-3 flex-grow-1">
                                                                                    <a href="#!" class="stretched-link">
                                                                                        <h6 class="fs-14 mb-1">{{ $expireContract->user->full_name }}</h6>
                                                                                    </a>
                                                                                    <p class="mb-0 text-muted">{{ $expireContract->company->title }}</p>
                                                                                </div>
                                                                                <div>
                                                                                    @if($expireContract->contract_end_date == \Carbon\Carbon::today())
                                                                                        <h6>
                                                                                            დღეს
                                                                                        </h6>
                                                                                    @else
                                                                                        <h6>
                                                                                            {{ $expireContract->formatted_contract_end_date }}
                                                                                        </h6>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="simplebar-placeholder"
                                                     style="width: auto; height: 200px;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                <div class="simplebar-scrollbar"
                                                     style="height: 299px; transform: translate3d(0px, 65px, 0px); display: block;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    @endif
                </div>


                @if(currentUser()->hasRole('System Administrator'))
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">@lang('today_movements') ({{ $todayMovements->count() }})</h4>

                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="today_movements">
                                        <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col">@lang('employee')</th>
                                            <th scope="col">@lang('company')</th>
                                            <th scope="col">@lang('day')</th>
                                            <th scope="col">@lang('date_of_announcement')</th>
                                            <th scope="col">@lang('expiration_date')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($todayMovements as $movement)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{--                                                    <div class="flex-shrink-0 me-2">--}}
                                                        {{--                                                        <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle">--}}
                                                        {{--                                                    </div>--}}
                                                        <div class="flex-grow-1">{{ $movement->user->full_name }}</div>
                                                    </div>
                                                </td>
                                                <td>{{ $movement->user->company->title }} ({{ $movement->user->company->identification_code }})</td>
                                                <td>{{ $movement->week_day_name }}</td>
                                                <td>
                                                    @if($movement->checkUser($movement->user['working_schedule']['week_days']))
                                                        <span
                                                            class="badge text-bg-success">{{ $movement->formatted_start_date }}</span>
                                                    @else
                                                        <span
                                                            class="badge text-bg-danger">{{ $movement->formatted_start_date }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($movement->checkUser($movement->user['working_schedule']['week_days'],true))
                                                        <span
                                                            class="badge text-bg-success">{{ $movement->formatted_end_date }}</span>
                                                    @else
                                                        <span
                                                            class="badge text-bg-danger">{{ $movement->formatted_end_date }}</span>
                                                    @endif
                                                </td>
                                            </tr><!-- end tr -->
                                        @endforeach
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div>

                @endif

            </div>


            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


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
        $(document).ready(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        $(document).ready(function () {
            table = $('#today_movements').DataTable({
                order: [ [3, 'desc'] ],
            })
        });

        function copyUserIp() {
            var copyText = document.getElementById('user_ip').textContent;
            navigator.clipboard.writeText(copyText).then(() => {
                // Alert the user that the action took place.
                // Nobody likes hidden stuff being done under the hood!
                //alert("Copied to clipboard");
                $(`#btn_room_num`).html('<i style="color: green" class="fa fa-check" aria-hidden="true"></i>');
                setTimeout(function () {
                    $(`#btn_room_num`).html('<i class="ri-file-copy-line"></i>');
                }, 500)
            });
        }
    </script>
@endpush
