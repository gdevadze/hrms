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
