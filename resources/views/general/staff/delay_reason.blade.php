<form class="row g-3" action="javascript:void(0)" id="delay_reason" method="POST">
    @csrf
    <div class="col-md-6">
        <input type="text" class="form-control" id="delay_reason" value="" name="delay_reason" required="">
    </div>
    <div class="col-6">
        <button class="btn btn-primary save-delay-reason-btn" type="submit" data-link="{{ route('user.movements.save.delay.reason',$data->id) }}">@lang('save')</button>
    </div>
</form>

