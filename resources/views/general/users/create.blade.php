<form action="javascript:void(0)" id="user_info" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('name_ka')</label>
                <input type="text" class="form-control" name="name_ka" value="" id="name_ka">
                <span class="text-danger errors name_ka_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('surname_ka')</label>
                <input type="text" class="form-control" name="surname_ka" value="" id="surname_ka">
                <span class="text-danger errors surname_ka_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('name_en')</label>
                <input type="text" class="form-control" name="name_en" value="" id="basiInput">
                <span class="text-danger errors name_en_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('surname_en')</label>
                <input type="text" class="form-control" name="surname_en" value="" id="basiInput">
                <span class="text-danger errors surname_en_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="tel" class="form-label">@lang('personal_number')</label>
                <input type="text" class="form-control" name="personal_num" value="" >
                <span class="text-danger errors personal_num_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="tel" class="form-label">@lang('phone')</label>
                <input type="text" class="form-control" name="tel" value="" id="tel" >
                <span class="text-danger errors tel_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('email')</label>
                <input type="text" class="form-control" name="email" value="" id="basiInput">
                <span class="text-danger errors email_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="birthdate" class="form-label">@lang('birthdate')</label>
                <input type="text" class="form-control flatpickr-input" name="birthdate" id="birthdate" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="birthdate" class="form-label">@lang('company')</label>
                <select class="form-select mb-3" name="company_id">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->title }} ({{ $company->identification_code }})</option>
                    @endforeach
                </select>
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('users.store') }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
<script src="{{ asset('assets/js/geokbd.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script>
    $(document).ready(function(){
        $('#tel').inputmask({"mask": "599 99 99 99"});
        $('#name_ka').geokbd();
        $('#surname_ka').geokbd();
        flatpickr('.flatpickr-input', {
            allowInput: true,
            onChange(_dates, currentDateString, _picker, _data){
                var divEl = document.createElement("div");
                divEl.innerHTML = `[${new Date().toISOString()}] change: ${currentDateString}`;
                document.querySelector("div").appendChild(divEl);
            },
            parseDate(date){
                var divEl = document.createElement("div");
                divEl.innerHTML = `[${new Date().toISOString()}] parsing ${date}`;
                document.querySelector("div").appendChild(divEl);
            }
        });
    });
</script>
