<form action="javascript:void(0)" id="user_info" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">დეპარტამენტი</label>
            <select class="form-control" name="department_id">
                <option selected value="">აირჩიეთ</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected($department->id == $position->department_id)>{{ $department->title }}</option>
                @endforeach
            </select>
            <span class="text-danger errors department_id_err"></span>
        </div>
        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">დასახელება</label>
            <input type="text" class="form-control flatpickr-input" value="{{ $position->title }}" name="title">
            <span class="text-danger errors title_err"></span>
        </div>
        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">მენეჯერი</label>
            <select class="form-control" name="manager_id">
                <option selected value="">აირჩიეთ</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($position->manager_id == $user->id)>{{ $user->full_name }}</option>
                @endforeach
            </select>
            <span class="text-danger errors title_err"></span>
        </div>

        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">მენეჯერი 2</label>
            <select class="form-control" name="helper_manager_id">
                <option selected value="">აირჩიეთ</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($position->helper_manager_id == $user->id)>{{ $user->full_name }}</option>
                @endforeach
            </select>
            <span class="text-danger errors title_err"></span>
        </div>

        <div class="col-xxl-12 col-md-12">
            <label for="basiInput" class="form-label">მენეჯერი 3</label>
            <select class="form-control" name="helper_id">
                <option selected value="">აირჩიეთ</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($position->helper_id == $user->id)>{{ $user->full_name }}</option>
                @endforeach
            </select>
            <span class="text-danger errors title_err"></span>
        </div>
    </div>
    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('settings.positions.update',$position->id) }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
