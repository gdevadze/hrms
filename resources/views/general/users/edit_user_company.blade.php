<form action="javascript:void(0)" id="user_info1" method="post">
    @csrf
<div class="row ">

    <div class="col-md-4">
        <div class="form-group">
            <label for="company_id_1">კომპანია</label>
            <select name="company_id" id="company_id_1" class="form-control">
                <option selected disabled>აირჩიეთ</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @selected($company->id == $userCompany->company_id)>{{ $company->title }} ({{ $company->identification_code }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="position_id_1">დეპარტამენტი</label>
            <select name="department_id" id="department_id_1" class="form-control">
                <option selected disabled>აირჩიეთ</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected($department->id == $userCompany->department_id)>{{ $department->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="position_id_1">პოზიცია</label>
            <select name="position_id" id="position_id_1" class="form-control">
                <option selected disabled>აირჩიეთ</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" @selected($position->id == $userCompany->position_id)>{{ $position->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="working_schedule_id_1">გრაფიკი</label>
            <select name="working_schedule_id" id="working_schedule_id_1" class="form-control">
                <option selected disabled>აირჩიეთ</option>
                @foreach($workingSchedules as $workingSchedule)
                    <option value="{{ $workingSchedule->id }}" @selected($workingSchedule->id == $userCompany->working_schedule_id)>{{ $workingSchedule->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6">
        <div>
            <label for="contract_dates_1" class="form-label">ხელშეკრულების დაწყების თარიღი</label>
            <input type="text" class="form-control flatpickr-input" name="contract_date" value="{{ $userCompany->formatted_contract_date }}" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly" id="contract_dates_1" >
            <span class="text-danger errors contract_dates_err"></span>
        </div>
    </div>
    <div class="col-xxl-4 col-md-6">
        <div>
            <label for="contact_end_dates_1" class="form-label">ხელშეკრულების დასრულების თარიღი</label>
            <input type="text" class="form-control flatpickr-input" name="contract_end_date" value="{{ $userCompany->formatted_contract_end_date }}" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly" id="contact_end_dates_1">
            <span class="text-danger errors contact_end_dates_err"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="contact_types_1">ხელშეკრულების ტიპი</label>
            <select name="contract_type_id" id="contact_types_1" class="form-control">
                <option selected disabled>აირჩიეთ</option>
                @foreach($contractTypes as $contractType)
                    <option value="{{ $contractType['key'] }}" @selected($contractType['key'] == $userCompany->contract_type_id)>{{ $contractType['title'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="mt-3">
    <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('users.update.user.company',$userCompany->id) }}" href="javascript:void(0)">@lang('save')</a>
</div>
</form>

<script>
    flatpickr('.flatpickr-input', {
        allowInput: true,
    });
</script>
