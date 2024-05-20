<form action="javascript:void(0)" id="user_info" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-6 col-md-6">
            <label for="basiInput" class="form-label">@lang('date_from')</label>
            <input type="text" class="form-control flatpickr-input" name="start_date" data-provider="flatpickr"
                   data-date-format="d.m.Y" readonly="readonly">
            <span class="text-danger errors start_date_err"></span>
        </div>
        <div class="col-xxl-6 col-md-6">
            <label for="basiInput" class="form-label">@lang('date_to')</label>
            <input type="text" class="form-control flatpickr-input" name="end_date" data-provider="flatpickr"
                   data-date-format="d.m.Y" readonly="readonly">
            <span class="text-danger errors end_date_err"></span>
        </div>
        @if(($userVacations - $usedUserVacations) > 0)
            <div class="col-xxl-6 col-md-6 mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="formCheck2" name="use_previous_year">
                    <label class="form-check-label" for="formCheck2">
                        წინა წლის შვებულების გამოყენება
                    </label>
                </div>
            </div>
        @endif
    </div>
    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn"
           data-link="{{ route('user.vacations.store') }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
<script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script src="{{ asset('assets/js/geokbd.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#tel').inputmask({"mask": "599 99 99 99"});
        $('#name_ka').geokbd();
        $('#surname_ka').geokbd();
        flatpickr('.flatpickr-input', {
            minDate: new Date().fp_incr(14)
        });
    });
</script>
