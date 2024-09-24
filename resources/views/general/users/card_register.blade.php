<form action="javascript:void(0)" id="user_info" method="post">
    @csrf
    <p>მომხმარებელი: {{ $user->full_name }}</p>
    <p>პირადი ნომერი: {{ $user->personal_num }}</p>
    <div class="col-xxl-12 col-md-12">
        <div>
            <label for="tel" class="form-label">ბარათის ნომერი</label>
            <input type="text" class="form-control" name="card_number" value="{{ $user->card_number }}" >
            <span class="text-danger errors card_number_err"></span>
        </div>
    </div>

    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('users.card.register',$user->id) }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
