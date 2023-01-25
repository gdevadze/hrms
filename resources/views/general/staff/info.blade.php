<div class="card-body">
    <ul class="nav nav-pills animation-nav nav-justified gap-2 mb-3" role="tablist">
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#animation-home" role="tab" aria-selected="true">
                მოძრაობა
            </a>
        </li>
        <li class="nav-item waves-effect waves-light" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#animation-profile" role="tab" aria-selected="false" tabindex="-1">
                ინფორმაცია
            </a>
        </li>
{{--        <li class="nav-item waves-effect waves-light" role="presentation">--}}
{{--            <a class="nav-link" data-bs-toggle="tab" href="#animation-messages" role="tab" aria-selected="false" tabindex="-1">--}}
{{--                Messages--}}
{{--            </a>--}}
{{--        </li>--}}
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
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>დღე</th>
                                <th>დაწყება</th>
                                <th>დასრულება</th>
                                <th>ნამუშევარი საათები</th>
                            </tr>
                            @foreach($user['movements'] as $key => $movement)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $movement->week_day_name ?? '' }}</td>
                                    <td>
                                        @if($movement->checkUser($user['working_schedule']['week_days']))
                                            <span style="color:green">{{ $movement->formatted_start_date }}</span>
                                        @else
                                            <span style="color:red">{{ $movement->formatted_start_date }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($movement->checkUser($user['working_schedule']['week_days'],true))
                                            <span style="color:green">{{ $movement->formatted_end_date }}</span>
                                        @else
                                            <span style="color:red">{{ $movement->formatted_end_date }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->worked_hours }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="Banner f16 text-center m-b-15">სამუშაო დღეები:<b class="text-danger"> {{ $workingAndMissedDays['working_days'] }}</b>, გაცდენა:<b class="text-danger"> {{ $workingAndMissedDays['missed_days'] }}</b>, დაგვიანება:<b class="text-danger"> {{ $employeeLateIncomes }}</b>, ადრე წასვლა:<b class="text-danger"> {{ $employeeGoEarly }}</b>, ნამუშევარი დღეები:<b class="text-danger"> {{ $workingAndMissedDays['actual_working_days'] }}</b>, სამსახურში: <b>{{ $totalWorkingTime }}</b></div>
                        <table class="table">
                            <tbody><tr>
                                <td class="text-center bg-success text-white">შესრულებული სამუშაო საათები</td>
{{--                                <td class="table-info text-center Banner">საპატიო მიზეზი</td>--}}
                                <td class="text-center bg-danger text-white">დაგვიანება / ადრე წასვლა</td>
                            </tr></tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="animation-profile" role="tabpanel">
            <form action="javascript:void(0)" id="user_info" method="post">
                @csrf
                <input hidden name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div>
                            <label for="basiInput" class="form-label">სახელი</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" id="basiInput">
                            <span class="text-danger errors name_err"></span>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div>
                            <label for="basiInput" class="form-label">გვარი</label>
                            <input type="text" class="form-control" name="surname" value="{{ $user->surname }}" id="basiInput">
                            <span class="text-danger errors surname_err"></span>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div>
                            <label for="tel" class="form-label">პირადი ნომერი</label>
                            <input type="text" class="form-control" name="personal_num" value="{{ $user->personal_num }}" >
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div>
                            <label for="tel" class="form-label">მობილური</label>
                            <input type="text" class="form-control" name="tel" value="{{ $user->tel }}" id="tel" >
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div>
                            <label for="basiInput" class="form-label">ელ. ფოსტა</label>
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}" id="basiInput">
                            <span class="text-danger errors email_err"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a type="button" class="btn btn-primary waves-effect waves-light save-btn" href="javascript:void(0)">შენახვა</a>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="animation-messages" role="tabpanel">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-fill text-success"></i>
                </div>
                <div class="flex-grow-1 ms-2">
                    Each design is a new, unique piece of art birthed into this world, and while you have the opportunity to be creative and make your own style choices.
                </div>
            </div>
            <div class="d-flex mt-2">
                <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-fill text-success"></i>
                </div>
                <div class="flex-grow-1 ms-2">
                    For that very reason, I went on a quest and spoke to many different professional graphic designers and asked them what graphic design tips they live.
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
<script>
    $(document).ready(function(){
        $('#tel').inputmask({"mask": "599 99 99 99"});
    });
</script>
