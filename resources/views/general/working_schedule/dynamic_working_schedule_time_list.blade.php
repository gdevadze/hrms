<form action="javascript:void(0)" id="set_time_user" method="post">
    @csrf
    <div class="row">
        <p>თარიღი: {{ $formattedDate }}</p>
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">სამუშაო გრაფიკი</label>
            <select class="form-control" data-choices name="dynamic_working_schedule_id">
                <option value="">აირჩიეთ</option>
                @foreach ($workingScheduleTimes as $dynamicTime)
                    <option value="{{ $dynamicTime->id }}">{{ $dynamicTime->title }}</option>
                @endforeach
            </select>
            <span class="text-danger errors title_err"></span>
        </div>

    </div>
    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('dynamic.working.schedule.set.time.users') }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
